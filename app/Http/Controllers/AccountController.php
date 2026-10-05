<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\City;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\State;
use App\Models\Wishlist;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();

        $orders = Order::where('customer_id', $customer->id)
            ->with(['items.product:id,slug'])
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
}