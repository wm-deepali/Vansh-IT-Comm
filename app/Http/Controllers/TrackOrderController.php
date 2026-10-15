<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('orderId', ''));
        $searched = $query !== '';
        $order = null;
        $stages = [];
        $isOffTrack = false;
        $offTrackMessage = null;

        $couriers = Courier::where('is_active', 1)
            ->orderBy('name')
            ->get(['id', 'name', 'website_url', 'icon']);

        if ($searched) {
            // Only the logged-in customer's own orders
            $order = Order::with(['courier', 'invoice', 'statusHistory', 'items:id,order_id,product_name,quantity'])
                ->where('customer_id', auth('customer')->id())
                ->where(function ($q) use ($query) {
                    $q->where('order_number', $query)
                        ->orWhere('tracking_number', $query);
                })
                ->first();
        }

        if ($order) {
            $status = strtolower((string) $order->status);

            // Admin "pending" and "new" are the same first stage
            if ($status === 'pending') {
                $status = 'new';
            }

            $offTrackMessages = [
                'cancelled' => 'This order was cancelled.',
                'ndr' => 'The courier could not deliver this order. A re-attempt will be arranged.',
                'rto' => 'This order is being returned to us.',
            ];

            $isOffTrack = isset($offTrackMessages[$status]);
            $offTrackMessage = $offTrackMessages[$status] ?? null;

            // Matches the statuses the admin panel can set
            $defs = [
                ['icon' => 'fa-check', 'title' => 'Order Placed', 'sub' => 'Order received', 'status' => 'new', 'match' => ['new', 'pending']],
                ['icon' => 'fa-clipboard-check', 'title' => 'Processing', 'sub' => 'Quality checked & packed', 'status' => 'processing', 'match' => ['processing']],
                ['icon' => 'fa-truck', 'title' => 'Shipped', 'sub' => 'Handed to courier', 'status' => 'shipped', 'match' => ['shipped']],
                ['icon' => 'fa-house-chimney', 'title' => 'Delivered', 'sub' => 'Delivered to doorstep', 'status' => 'delivered', 'match' => ['delivered']],
            ];

            $current = 0;
            foreach ($defs as $i => $d) {
                if ($status === $d['status']) {
                    $current = $i;
                }
            }

            $historyAsc = $order->statusHistory->sortBy('created_at');
            $last = count($defs) - 1;

            foreach ($defs as $i => $d) {
                $entry = $historyAsc->first(
                    fn ($h) => in_array(strtolower((string) $h->status), $d['match'], true)
                );

                $stages[] = $d + [
                    'state' => ($i < $current || ($i === $current && $current === $last)) ? 'done'
                        : ($i === $current ? 'current' : 'pending'),
                    // first stage falls back to the order's created date
                    'date' => $entry?->created_at ?? ($i === 0 ? $order->created_at : null),
                ];
            }
        }

        return view('front-pages.track-order', compact(
            'query',
            'searched',
            'order',
            'stages',
            'isOffTrack',
            'offTrackMessage',
            'couriers'
        ));
    }
}