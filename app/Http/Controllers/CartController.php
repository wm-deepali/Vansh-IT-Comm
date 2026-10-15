<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\AttributeValue;
use App\Models\ProductAddon;
use App\Services\Tracking\PixelTracker;
use App\Models\CategoryAttribute;
use App\Models\ShippingSetting;
use App\Services\ShippingCalculator;

class CartController extends Controller
{

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',

            // value ids the customer picked on the product page (variant ids are resolved on the server)
            'selected_values' => 'nullable|array',
            'selected_values.*' => 'integer|exists:attribute_values,id',

            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'integer|exists:product_addons,id',

            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::with([
            'variants' => fn($q) => $q->where('status', 1)->with('values'),
            'attributeValues.value',
        ])->findOrFail($request->product_id);

        $quantity = $request->quantity ?? $product->min_qty;

        /*
        |--------------------------------------------------------------------------
        | Resolve the selection on the server (picked + single-value + defaults)
        |--------------------------------------------------------------------------
        */
        [$selection, $snapshotIds] = $this->resolveSelection($product, (array) $request->selected_values);

        $resolve = function (string $type) use ($product, $selection) {
            $best = null;

            foreach ($product->variants->where('type', $type) as $variant) {
                $ids = $variant->values->pluck('attribute_value_id')->map(fn($i) => (int) $i);

                if ($ids->isEmpty() || $ids->diff($selection)->isNotEmpty()) {
                    continue;
                }

                if (!$best || $ids->count() > $best->values->count()) {
                    $best = $variant;
                }
            }

            return $best;
        };

        $priceVariant = $resolve('price');
        $imageVariant = $resolve('image');
        $stockVariant = $resolve('stock');
        $skuVariant = $resolve('sku');

        $price = ($priceVariant && $priceVariant->price > 0) ? $priceVariant->price : $product->price;

        $stock = $stockVariant
            ? ($stockVariant->is_available ? (int) $stockVariant->stock : 0)
            : (int) $product->stock;

        if ($stock < $product->min_qty) {
            return response()->json([
                'status' => false,
                'message' => 'Product is out of stock.'
            ], 422);
        }

        if ($quantity > $stock) {
            return response()->json([
                'status' => false,
                'message' => "Only {$stock} units available."
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Snapshot of the chosen variant attributes (Size: L, Color: Red) — also
        | includes attributes that have only one value and no selector.
        |--------------------------------------------------------------------------
        */
        $selectedAttributes = [];

        if (!empty($snapshotIds)) {
            $selectedAttributes = AttributeValue::with('attribute')
                ->whereIn('id', $snapshotIds)
                ->get()
                ->map(fn($av) => [
                    'attribute_id' => $av->attribute_id,
                    'attribute' => $av->attribute->name ?? null,
                    'value_id' => $av->id,
                    'value' => $av->value,
                ])
                ->values()
                ->toArray();
        }

        /*
        |--------------------------------------------------------------------------
        | Selected addons — snapshot detail + price (per unit)
        |--------------------------------------------------------------------------
        */
        $selectedAddons = collect();

        if ($request->filled('addon_ids')) {
            $selectedAddons = ProductAddon::where('product_id', $product->id)
                ->whereIn('id', $request->addon_ids)
                ->get();
        }

        $addonUnitTotal = $selectedAddons->sum('price');

        /*
        |--------------------------------------------------------------------------
        | Get Cart
        |--------------------------------------------------------------------------
        */
        if (auth('customer')->check()) {

            $customer = auth('customer')->user();

            $cart = Cart::firstOrCreate(
                ['user_id' => $customer->id],
                [
                    'session_id' => session()->getId(),
                    'total_amount' => 0,
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax_amount' => 0,
                    'grand_total' => 0,
                ]
            );

        } else {

            $cart = Cart::firstOrCreate(
                ['session_id' => session()->getId()],
                [
                    'total_amount' => 0,
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax_amount' => 0,
                    'grand_total' => 0,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Item — merge only when the product, the 4 variant ids AND the
        | chosen attribute values are identical (and no addons).
        |--------------------------------------------------------------------------
        */
        $item = null;

        if ($selectedAddons->isEmpty()) {

            $signature = collect($snapshotIds)->map(fn($i) => (int) $i)->sort()->values()->all();

            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->where('price_variant_id', $priceVariant->id ?? null)
                ->where('image_variant_id', $imageVariant->id ?? null)
                ->where('stock_variant_id', $stockVariant->id ?? null)
                ->where('sku_variant_id', $skuVariant->id ?? null)
                ->doesntHave('addons')
                ->get()
                ->first(function ($line) use ($signature) {
                    $ids = collect($line->selected_attributes ?? [])
                        ->pluck('value_id')
                        ->map(fn($i) => (int) $i)
                        ->sort()
                        ->values()
                        ->all();

                    return $ids === $signature;
                });
        }

        if ($item) {

            $newQty = $item->quantity + $quantity;

            if ($newQty > $stock) {
                return response()->json([
                    'status' => false,
                    'message' => "Only {$stock} units available."
                ], 422);
            }

            $item->quantity = $newQty;
            $item->total = $item->quantity * ($item->price + $addonUnitTotal);
            $item->save();

        } else {

            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,

                'price_variant_id' => $priceVariant->id ?? null,
                'image_variant_id' => $imageVariant->id ?? null,
                'stock_variant_id' => $stockVariant->id ?? null,
                'sku_variant_id' => $skuVariant->id ?? null,

                'selected_attributes' => $selectedAttributes,

                'quantity' => $quantity,
                'price' => $price,
                'total' => $quantity * ($price + $addonUnitTotal),
            ]);

            foreach ($selectedAddons as $addon) {
                $item->addons()->create([
                    'addon_id' => $addon->id,
                    'detail' => $addon->detail,
                    'price' => $addon->price,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Recalculate Cart
        |--------------------------------------------------------------------------
        */
        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        if ($couponResult && $couponResult['removed']) {
            $cart->recalculateTotals();
            $cart->refresh();
        }

        $trackingEvents = PixelTracker::addToCart($product, $quantity, $price);

        $cart->load([
            'items.product',
            'items.imageVariant',
            'items.addons',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully.',
            'cart_count' => (int) $cart->items()->sum('quantity'),
            'tracking_events' => $trackingEvents,
        ]);
    }

    /**
     * Build the full selection for a product.
     *
     * Returns [ $selection, $snapshotIds ]
     *  - $selection   : every attribute_value id used to match variants
     *                   (customer's pick or default for selectable attributes,
     *                   all values for the others) — same rule as the product page JS.
     *  - $snapshotIds : the used_for_variant values to store on the cart line,
     *                   including attributes that have only one value.
     */
    private function resolveSelection(Product $product, array $requested): array
    {
        $variantAttrIds = CategoryAttribute::whereIn(
            'category_id',
            array_filter([$product->category_id, $product->subcategory_id])
        )
            ->where('status', 1)
            ->where('used_for_variant', true)
            ->pluck('attribute_id')
            ->unique()
            ->all();

        // No pick sent (e.g. listing page): seed from an in-stock stock variant
        $seed = array_map('intval', $requested);

        if (empty($seed)) {
            $stockVariants = $product->variants->where('type', 'stock');
            $default = $stockVariants->first(fn($v) => $v->is_available && $v->stock > 0)
                ?? $stockVariants->first();

            $seed = $default
                ? $default->values->pluck('attribute_value_id')->map(fn($i) => (int) $i)->all()
                : [];
        }

        $byAttribute = $product->attributeValues
            ->sortBy(fn($av) => $av->value->sort_order ?? 0)
            ->groupBy('attribute_id');

        $selection = [];
        $snapshotIds = [];

        foreach ($byAttribute as $attributeId => $rows) {
            $valueIds = $rows->pluck('attribute_value_id')->map(fn($i) => (int) $i)->unique()->values();
            $isVariantAttr = in_array($attributeId, $variantAttrIds);

            if ($isVariantAttr && $valueIds->count() > 1) {
                // selectable: customer's pick if valid for this product, else the first value
                $chosen = $valueIds->first(fn($id) => in_array($id, $seed, true)) ?? $valueIds->first();

                $selection[] = $chosen;
                $snapshotIds[] = $chosen;
                continue;
            }

            // not selectable: all of its values take part in matching
            foreach ($valueIds as $id) {
                $selection[] = $id;
            }

            // single-value variant attribute: store it too
            if ($isVariantAttr) {
                $snapshotIds[] = $valueIds->first();
            }
        }

        return [array_values(array_unique($selection)), array_values(array_unique($snapshotIds))];
    }

    public function cart()
    {
        $with = [
            'items.product.images',
            'items.product.category',
            'items.product.subcategory',
            'items.priceVariant',
            'items.addons',
        ];

        if (auth('customer')->check()) {

            $cart = Cart::with($with)
                ->where('user_id', auth('customer')->id())
                ->first();

        } else {

            $cart = Cart::with($with)
                ->where('session_id', session()->getId())
                ->first();
        }

        // Recalculate GST based on latest default address
        if ($cart) {
            $cart->recalculateTotals();
            $cart->refresh();

            // Cart may have been touched from another tab/request since the coupon was applied
            $this->revalidateCoupon($cart);
            $cart->refresh();

            // refresh() drops loaded relations — reload them for the view
            $cart->load($with);
        }

        $summary = $cart ? $this->summaryPayload($cart) : null;

        // Free-delivery threshold comes from Shipping Settings (0 = disabled)
        $freeShipAt = (float) (ShippingSetting::first()->free_delivery_threshold ?? 0);
        
        return view(
            'front-pages.cart',
            compact('cart', 'summary', 'freeShipAt')
        );
    }

    public function remove($id)
    {
        $item = CartItem::findOrFail($id);

        if (auth('customer')->check()) {
            if ($item->cart->user_id != auth('customer')->id()) {
                abort(403);
            }
        } else {
            if ($item->cart->session_id != session()->getId()) {
                abort(403);
            }
        }

        $cart = $item->cart;

        // capture before delete — product/qty/price won't exist on $item after this
        $trackingEvents = PixelTracker::removeFromCart(
            $item->product,
            $item->quantity,
            $item->price
        );

        $item->delete();

        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        if ($couponResult && $couponResult['removed']) {
            $cart->recalculateTotals();
            $cart->refresh();
        }

        $cart->load(['items.product', 'items.imageVariant', 'items.addons']);

        return response()->json([
            'status' => true,
            'message' => 'Item removed successfully',
            'cart_count' => (int) $cart->items()->sum('quantity'),
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'summary' => $this->summaryPayload($cart),
            'tracking_events' => $trackingEvents,
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'action' => 'required|in:plus,minus',
        ]);

        $item = CartItem::findOrFail($request->item_id);

        if (auth('customer')->check()) {

            if ($item->cart->user_id != auth('customer')->id()) {
                abort(403);
            }

        } else {

            if ($item->cart->session_id != session()->getId()) {
                abort(403);
            }
        }

        // Stock now comes from the item's stock-variant (if any), else the
        // base product — same idea as before, just repointed to the new column.
        $stock = $item->stockVariant
            ? $item->stockVariant->stock
            : $item->product->stock;

        $minQty = $item->product->min_qty;

        if ($request->action == 'plus') {

            if ($item->quantity + 1 > $stock) {

                return response()->json([
                    'status' => false,
                    'message' => 'Only ' . $stock . ' units available in stock.'
                ], 422);
            }

            $item->quantity++;

        } elseif ($request->action == 'minus') {

            if ($item->quantity - 1 >= $minQty) {
                $item->quantity--;
            }
        }

        // Addon prices are per-unit, so they scale with quantity too — same
        // rule as the "Add to Cart" price computation.
        $addonUnitTotal = $item->addons->sum('price');

        $item->total = $item->quantity * ($item->price + $addonUnitTotal);
        $item->save();

        $cart = $item->cart;

        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        if ($couponResult && $couponResult['removed']) {
            $cart->recalculateTotals();
            $cart->refresh();
        }

        $totalMrp = $this->itemMrp($item) * $item->quantity;

        $cart->load(['items.product', 'items.imageVariant', 'items.addons']);

        return response()->json([
            'status' => true,
            'quantity' => $item->quantity,
            'item_total' => $item->total,
            'total_mrp' => $totalMrp,
            'cart_count' => (int) $cart->items()->sum('quantity'),
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'summary' => $this->summaryPayload($cart),
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required'
        ]);

        $cart = auth('customer')->check()
            ? Cart::where('user_id', auth('customer')->id())->first()
            : Cart::where('session_id', session()->getId())->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart not found'
            ]);
        }

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {

            return response()->json([
                'status' => false,
                'message' => 'Invalid coupon code'
            ]);
        }

        if ($coupon->start_date && now()->lt($coupon->start_date)) {

            return response()->json([
                'status' => false,
                'message' => 'Coupon not started yet'
            ]);
        }

        if ($coupon->end_date && now()->gt($coupon->end_date)) {

            return response()->json([
                'status' => false,
                'message' => 'Coupon expired'
            ]);
        }

        $subtotal = $cart->items()->sum('total');

        if (
            $coupon->minimum_order_amount &&
            $subtotal < $coupon->minimum_order_amount
        ) {

            return response()->json([
                'status' => false,
                'message' => 'Minimum order amount not reached'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Minimum Order Quantity Check
        |--------------------------------------------------------------------------
        */

        $totalQuantity = $cart->items()->sum('quantity');

        if (
            $coupon->minimum_order_quantity &&
            $totalQuantity < $coupon->minimum_order_quantity
        ) {

            $remainingQty = $coupon->minimum_order_quantity - $totalQuantity;

            return response()->json([
                'status' => false,
                'message' => "Add {$remainingQty} more item" . ($remainingQty > 1 ? 's' : '') . " to unlock this coupon (minimum {$coupon->minimum_order_quantity} items required)."
            ]);
        }

        if ($coupon->discount_type == 'percentage') {

            $discount =
                ($subtotal * $coupon->discount_value) / 100;

            if (
                $coupon->maximum_discount &&
                $discount > $coupon->maximum_discount
            ) {
                $discount = $coupon->maximum_discount;
            }

        } else {

            $discount = $coupon->discount_value;
        }

        $cart->update([
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'discount' => $discount
        ]);

        $cart->recalculateTotals();
        $cart->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully',
            'summary' => $this->summaryPayload($cart),
        ]);
    }

    public function removeCoupon()
    {
        $cart = auth('customer')->check()
            ? Cart::where('user_id', auth('customer')->id())->first()
            : Cart::where('session_id', session()->getId())->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart not found'
            ], 404);
        }

        $cart->update([
            'coupon_id' => null,
            'coupon_code' => null,
            'discount' => 0
        ]);

        $cart->recalculateTotals();
        $cart->refresh();

        return response()->json([
            'status' => true,
            'summary' => $this->summaryPayload($cart),
        ]);
    }

    public function clear()
    {
        $cart = auth('customer')->check()
            ? Cart::where('user_id', auth('customer')->id())->first()
            : Cart::where('session_id', session()->getId())->first();

        if ($cart) {

            foreach ($cart->items()->with('addons')->get() as $item) {
                $item->addons()->delete();
                $item->delete();
            }

            $cart->update([
                'coupon_id' => null,
                'coupon_code' => null,
                'discount' => 0
            ]);

            $cart->recalculateTotals();
        }

        return response()->json([
            'status' => true,
            'message' => 'Cart cleared.'
        ]);
    }

    /**
     * MRP of one cart line per unit (price-variant MRP, else product MRP,
     * else the sale price) plus per-unit addons. Multiply by quantity for
     * the line's total MRP.
     */
    private function itemMrp(CartItem $item): float
    {
        $base = $item->priceVariant?->mrp ?: $item->product?->mrp ?: $item->price;

        return (float) ($base + $item->addons->sum('price'));
    }

    /**
     * Everything the cart page's order summary needs, in one array.
     * Used for the initial render and returned in every AJAX response.
     */
    private function summaryPayload(Cart $cart): array
    {
        $cart->load(['items.product', 'items.priceVariant', 'items.addons']);

        $mrpTotal = $cart->items->sum(fn($i) => $this->itemMrp($i) * $i->quantity);

        // Same basis the shipping calculator and free-delivery bar use:
        // items total minus coupon discount (NOT $cart->subtotal, which has GST stripped in inclusive mode)
        $payable = max(0, (float) $cart->items->sum('total') - (float) $cart->discount);
        $ship = ShippingCalculator::forCart($cart, $payable);
        $subtotal = (float) $cart->subtotal;

        return [
            'count' => (int) $cart->items->sum('quantity'),
            'mrp_total' => (float) $mrpTotal,
            'savings' => max(0, (float) $mrpTotal - $subtotal),
            'subtotal' => $subtotal,
            'discount' => (float) $cart->discount,
            'tax' => (float) $cart->tax_amount,
            'grand_total' => (float) $cart->grand_total,
            'coupon_code' => $cart->coupon_code,

            'payable' => $payable,
            'shipping' => (float) $cart->shipping_charge,
            'shipping_known' => $ship['known'],
            'shipping_free' => $ship['free'],
            'shipping_zone' => $ship['zone'],
        ];
    }

    /**
     * Re-check an applied coupon's conditions against the cart's current
     * subtotal/quantity. Removes the coupon if it no longer qualifies,
     * and re-syncs a percentage discount's amount if the subtotal shifted.
     *
     * Call this after any operation that changes cart contents (add,
     * remove, quantity update) — right after recalculateTotals()/refresh().
     */
    private function revalidateCoupon(Cart $cart): ?array
    {
        if (!$cart->coupon_id) {
            return null;
        }

        $coupon = Coupon::find($cart->coupon_id);

        if (!$coupon || !$coupon->status) {
            $cart->update(['coupon_id' => null, 'coupon_code' => null, 'discount' => 0]);

            return [
                'removed' => true,
                'message' => 'Your applied coupon is no longer available and has been removed.',
            ];
        }

        $subtotal = $cart->subtotal;
        $totalQuantity = $cart->items()->sum('quantity');

        $amountOk = !$coupon->minimum_order_amount || $subtotal >= $coupon->minimum_order_amount;
        $qtyOk = !$coupon->minimum_order_quantity || $totalQuantity >= $coupon->minimum_order_quantity;

        if (!$amountOk || !$qtyOk) {
            $cart->update(['coupon_id' => null, 'coupon_code' => null, 'discount' => 0]);

            return [
                'removed' => true,
                'message' => "Coupon \"{$coupon->code}\" was removed — your cart no longer meets its minimum requirement.",
            ];
        }

        // Cart still qualifies — but a percentage discount amount needs to
        // track the new subtotal (flat discounts don't change).
        if ($coupon->discount_type === 'percentage') {
            $discount = ($subtotal * $coupon->discount_value) / 100;

            if ($coupon->maximum_discount && $discount > $coupon->maximum_discount) {
                $discount = $coupon->maximum_discount;
            }

            if ((float) $discount !== (float) $cart->discount) {
                $cart->update(['discount' => $discount]);
            }
        }

        return ['removed' => false];
    }

}