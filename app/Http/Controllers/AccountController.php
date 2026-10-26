<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\City;
use App\Models\CustomerAddress;
use App\Models\InvoiceSetting;
use App\Models\Order;
use App\Models\State;
use App\Models\Wishlist;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();

        $orders = Order::where('customer_id', $customer->id)
            ->with(['items.product:id,slug', 'invoice'])
            ->latest()
            ->paginate(10);

        $addresses = CustomerAddress::where('customer_id', $customer->id)
            ->with(['state', 'city'])
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        $states = State::orderBy('name')->get(['id', 'name']);
        $wishlistCount = Wishlist::current()->count();

        return view('front-pages.account', compact('customer', 'orders', 'addresses', 'states', 'wishlistCount'));
    }

    // ── Order detail ──────────────────────────────────────────────────────────
    public function orderShow($order)
    {
        $order = $this->ownedOrder($order, [
            'items.product.images',
            'items.imageVariant',
            'items.skuVariant',
            'items.addons',
            'state',
            'city',
            'courier',
            'invoice',
            'statusHistory',
        ]);

        [$stages, $isCancelled] = $this->buildStages($order);

        return view('front-pages.order-detail', compact('order', 'stages', 'isCancelled'));
    }

    // ── Invoice: browser preview (only when an invoice exists) ────────────────
    public function orderInvoice($order)
    {
        $order = $this->ownedOrder($order, [
            'invoice',
            'items.product',
            'items.skuVariant',
            'items.addons',
            'state',
            'city',
        ]);

        if (!$order->invoice) {
            return redirect()
                ->route('user.account.orders.show', $order->id)
                ->with('error', 'Invoice is not available for this order yet.');
        }

        return view('admin.orders.invoice', $this->invoiceViewData($order) + [
            'backUrl' => route('user.account.orders.show', $order->id),
            'downloadUrl' => route('user.account.orders.invoice.download', $order->id),
        ]);
    }

    // ── Invoice: PDF download (only when an invoice exists) ───────────────────
    public function orderInvoiceDownload($order)
    {
        $order = $this->ownedOrder($order, [
            'invoice',
            'items.product',
            'items.skuVariant',
            'items.addons',
            'state',
            'city',
        ]);

        if (!$order->invoice) {
            return redirect()
                ->route('user.account.orders.show', $order->id)
                ->with('error', 'Invoice is not available for this order yet.');
        }

        $pdf = Pdf::loadView('admin.orders.invoice', $this->invoiceViewData($order) + [
            'isPdf' => true, // hides the print bar in the view
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'dpi' => 150,
            ]);

        return $pdf->download($this->invoiceFileName($order));
    }

    public function cities($stateId)
    {
        return response()->json(
            City::where('state_id', $stateId)->orderBy('name')->get(['id', 'name'])
        );
    }

    public function storeAddress(AddressRequest $request)
    {
        $data = $request->validated();
        $customerId = auth('customer')->id();

        DB::transaction(function () use ($data, $customerId) {
            $hasAny = CustomerAddress::where('customer_id', $customerId)->exists();
            $makeDefault = !$hasAny || !empty($data['is_default']);

            if ($makeDefault) {
                CustomerAddress::where('customer_id', $customerId)->update(['is_default' => false]);
            }

            CustomerAddress::create([
                'customer_id'    => $customerId,
                'name'           => $data['name'],
                'email'          => $data['email'],
                'phone'          => $data['phone'],
                'address_line_1' => $data['address_line_1'],
                'address_line_2' => $data['address_line_2'] ?? null,
                'state_id'       => $data['state_id'],
                'city_id'        => $data['city_id'],
                'pincode'        => $data['pincode'],
                'address_type'   => $data['address_type'] ?? 'home',
                'is_default'     => $makeDefault,
            ]);
        });

        return response()->json(['status' => true, 'message' => 'Address added.']);
    }

    public function updateAddress(AddressRequest $request, $id)
    {
        $address = $this->ownedAddress($id);
        $data = $request->validated();

        DB::transaction(function () use ($address, $data) {
            $makeDefault = !empty($data['is_default']);

            if ($makeDefault) {
                CustomerAddress::where('customer_id', $address->customer_id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }

            $address->update([
                'name'           => $data['name'],
                'email'          => $data['email'],
                'phone'          => $data['phone'],
                'address_line_1' => $data['address_line_1'],
                'address_line_2' => $data['address_line_2'] ?? null,
                'state_id'       => $data['state_id'],
                'city_id'        => $data['city_id'],
                'pincode'        => $data['pincode'],
                'address_type'   => $data['address_type'] ?? 'home',
                // never un-default the only default via edit; use "Set as default" on another address
                'is_default'     => $makeDefault || $address->is_default,
            ]);
        });

        return response()->json(['status' => true, 'message' => 'Address updated.']);
    }

    public function setDefaultAddress($id)
    {
        $address = $this->ownedAddress($id);

        DB::transaction(function () use ($address) {
            CustomerAddress::where('customer_id', $address->customer_id)->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return response()->json(['status' => true, 'message' => 'Default address changed.']);
    }

    public function destroyAddress($id)
    {
        $address = $this->ownedAddress($id);

        try {
            DB::transaction(function () use ($address) {
                $wasDefault = $address->is_default;
                $customerId = $address->customer_id;

                $address->delete();

                if ($wasDefault) {
                    CustomerAddress::where('customer_id', $customerId)->latest()->first()
                        ?->update(['is_default' => true]);
                }
            });
        } catch (QueryException $e) {
            // orders.address_id foreign key without nullOnDelete
            return response()->json([
                'status'  => false,
                'message' => 'This address is linked to an order and cannot be deleted.',
            ], 409);
        }

        return response()->json(['status' => true, 'message' => 'Address deleted.']);
    }

    private function ownedAddress($id): CustomerAddress
    {
        return CustomerAddress::where('customer_id', auth('customer')->id())->findOrFail($id);
    }

    /**
     * Only ever returns an order that belongs to the logged-in customer.
     * Anyone else's order id is a plain 404.
     */
    private function ownedOrder($id, array $with = []): Order
    {
        return Order::with($with)
            ->where('customer_id', auth('customer')->id())
            ->findOrFail($id);
    }

    /**
     * Safe PDF filename. Invoice numbers like "INV/2026/001" contain "/" which
     * Symfony's Content-Disposition rejects ("filename and the fallback cannot
     * contain the '/' and '\' characters"), so strip anything unsafe.
     */
    private function invoiceFileName(Order $order): string
    {
        $number = (string) $order->invoice->invoice_number;
        $safe = trim(preg_replace('/[^A-Za-z0-9._-]+/', '-', $number), '-');

        return 'Invoice-' . ($safe !== '' ? $safe : $order->id) . '.pdf';
    }

    /**
     * Same data the admin invoice view needs (company settings + logo as base64 for dompdf).
     */
    private function invoiceViewData(Order $order): array
    {
        $setting = InvoiceSetting::with(['state', 'city'])->first();

        $logo_64 = null;

        if ($setting?->company_logo) {
            $logoPath = storage_path('app/public/' . $setting->company_logo);

            if (file_exists($logoPath)) {
                $mime = mime_content_type($logoPath);

                $logo_64 = 'data:' . $mime . ';base64,' .
                    base64_encode(file_get_contents($logoPath));
            }
        }

        return [
            'order' => $order,
            'invoice' => $order->invoice,
            'setting' => $setting,
            'logo_64' => $logo_64,
        ];
    }

    /**
     * Tracker stages for the order detail page.
     * Returns [stages, isCancelled]. Unknown statuses return no stages
     * (the status badge in the page header still shows).
     */
    private function buildStages(Order $order): array
    {
        $status = strtolower((string) $order->status);

        if ($status === 'pending') {
            $status = 'new'; // admin "pending" and "new" are the same first stage
        }

        if (in_array($status, ['cancelled', 'canceled'], true)) {
            return [[], true];
        }

        $defs = [
            ['icon' => 'fa-check', 'title' => 'Order Placed', 'sub' => 'Order received', 'status' => 'new', 'match' => ['new', 'pending']],
            ['icon' => 'fa-clipboard-check', 'title' => 'Processing', 'sub' => 'Quality checked & packed', 'status' => 'processing', 'match' => ['processing']],
            ['icon' => 'fa-truck', 'title' => 'Shipped', 'sub' => 'Handed to courier', 'status' => 'shipped', 'match' => ['shipped']],
            ['icon' => 'fa-house-chimney', 'title' => 'Delivered', 'sub' => 'Delivered to doorstep', 'status' => 'delivered', 'match' => ['delivered']],
        ];

        $current = null;
        foreach ($defs as $i => $d) {
            if ($d['status'] === $status) {
                $current = $i;
            }
        }

        if ($current === null) {
            return [[], false];
        }

        $historyAsc = $order->statusHistory->sortBy('created_at');
        $last = count($defs) - 1;
        $stages = [];

        foreach ($defs as $i => $d) {
            $entry = $historyAsc->first(
                fn ($h) => in_array(strtolower((string) $h->status), $d['match'], true)
            );

            $stages[] = $d + [
                'state' => ($i < $current || ($i === $current && $current === $last)) ? 'done'
                    : ($i === $current ? 'current' : 'pending'),
                'date' => $entry?->created_at ?? ($i === 0 ? $order->created_at : null),
            ];
        }

        return [$stages, false];
    }
}