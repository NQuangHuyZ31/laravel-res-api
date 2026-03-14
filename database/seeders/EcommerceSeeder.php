<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Shipment;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedCatalog();
        $this->seedCustomers();
        $this->seedCustomerActivities();
        $this->seedOrders();
    }

    private function seedCatalog(): void
    {
        $brands = collect([
            'Apple',
            'Samsung',
            'Dell',
            'ASUS',
            'Lenovo',
            'Logitech',
            'Anker',
            'Xiaomi',
        ])->map(fn (string $name) => Brand::factory()->create([
            'name' => $name,
            'slug' => strtolower(str_replace(' ', '-', $name)),
        ]));

        $rootCategories = [
            'Laptop' => ['Laptop Gaming', 'Laptop Ultrabook', 'MacBook'],
            'Dien Thoai' => ['Android', 'iPhone'],
            'Linh Kien' => ['RAM', 'SSD', 'Mainboard', 'CPU'],
            'Sac Du Phong' => ['Sac Nhanh', 'Sac Khong Day'],
        ];

        $leafCategories = collect();

        foreach ($rootCategories as $root => $children) {
            $rootCategory = Category::factory()->create([
                'name' => $root,
                'slug' => strtolower(str_replace(' ', '-', $root)),
                'parent_id' => null,
            ]);

            foreach ($children as $child) {
                $leafCategories->push(Category::factory()->create([
                    'name' => $child,
                    'slug' => strtolower(str_replace(' ', '-', $child)),
                    'parent_id' => $rootCategory->id,
                ]));
            }
        }

        Product::factory(80)->create([
            'brand_id' => fn () => $brands->random()->id,
            'category_id' => fn () => $leafCategories->random()->id,
        ])->each(function (Product $product): void {
            $variants = ProductVariant::factory(rand(1, 4))->create([
                'product_id' => $product->id,
            ]);

            $variants->each(function (ProductVariant $variant, int $index): void {
                if ($index === 0 && !$variant->is_default) {
                    $variant->update(['is_default' => true]);
                }
            });

            ProductImage::factory(rand(2, 5))->create([
                'product_id' => $product->id,
                'product_variant_id' => null,
            ]);
        });
    }

    private function seedCustomers(): void
    {
        User::factory()->create([
            'name' => 'Admin Ecommerce',
            'email' => 'admin@flyway.local',
            'role' => 'admin',
        ]);

        User::factory(120)->create();

        User::query()->where('role', 'customer')->get()->each(function (User $user): void {
            $addressCount = rand(1, 2);
            $addresses = Address::factory($addressCount)->create([
                'user_id' => $user->id,
            ]);

            $defaultAddress = $addresses->first();
            if ($defaultAddress) {
                $defaultAddress->update(['is_default' => true]);
            }
        });

        Coupon::factory(20)->create();
    }

    private function seedCustomerActivities(): void
    {
        $products = Product::query()->pluck('id');
        $activeUsers = User::query()->where('role', 'customer')->inRandomOrder()->limit(80)->get();

        $activeUsers->each(function (User $user) use ($products): void {
            $wishlist = Wishlist::factory()->create(['user_id' => $user->id]);
            $wishlistProductIds = $products->random(rand(2, 6));

            foreach ($wishlistProductIds as $productId) {
                WishlistItem::factory()->create([
                    'wishlist_id' => $wishlist->id,
                    'product_id' => $productId,
                ]);
            }

            $cart = Cart::factory()->create([
                'user_id' => $user->id,
                'status' => 'active',
            ]);

            $cartProductIds = $products->random(rand(1, 4));
            foreach ($cartProductIds as $productId) {
                $variantId = ProductVariant::query()
                    ->where('product_id', $productId)
                    ->inRandomOrder()
                    ->value('id');

                CartItem::factory()->create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'product_variant_id' => $variantId,
                ]);
            }
        });
    }

    private function seedOrders(): void
    {
        $customers = User::query()->where('role', 'customer')->get();
        $coupons = Coupon::query()->get();

        foreach (range(1, 200) as $index) {
            $customer = $customers->random();
            $addressId = Address::query()->where('user_id', $customer->id)->value('id');

            $order = Order::factory()->create([
                'user_id' => $customer->id,
                'address_id' => $addressId,
                'order_code' => 'ORD-' . now()->format('ymd') . '-' . str_pad((string) $index, 5, '0', STR_PAD_LEFT),
            ]);

            $itemCount = rand(1, 4);
            $lineItems = collect();

            foreach (range(1, $itemCount) as $_) {
                $variant = ProductVariant::query()->inRandomOrder()->first();
                if (!$variant) {
                    continue;
                }

                $product = Product::query()->find($variant->product_id);
                if (!$product) {
                    continue;
                }

                $qty = rand(1, 2);
                $unitPrice = (float) ($variant->sale_price ?: $variant->price);
                $lineTotal = $qty * $unitPrice;

                $lineItems->push(OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant->id,
                    'product_name' => $product->name,
                    'variant_name' => $variant->name,
                    'sku' => $variant->sku,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ]));

                InventoryTransaction::factory()->create([
                    'product_variant_id' => $variant->id,
                    'order_id' => $order->id,
                    'transaction_type' => 'sale',
                    'quantity_change' => -1 * $qty,
                    'reference_type' => 'customer_order',
                    'reference_code' => $order->order_code,
                ]);
            }

            $subtotal = (float) $lineItems->sum('line_total');
            $shippingFee = rand(0, 40000);
            $taxTotal = (float) round($subtotal * 0.08, 2);
            $discount = 0.0;
            $usedCoupon = null;

            if ($coupons->isNotEmpty() && rand(1, 100) <= 35) {
                $usedCoupon = $coupons->random();
                if ($usedCoupon->discount_type === 'fixed') {
                    $discount = (float) min($usedCoupon->discount_value, $subtotal);
                } else {
                    $discount = (float) round($subtotal * ($usedCoupon->discount_value / 100), 2);
                    if ($usedCoupon->maximum_discount_amount) {
                        $discount = min($discount, (float) $usedCoupon->maximum_discount_amount);
                    }
                }
            }

            $grandTotal = max(0, $subtotal - $discount + $shippingFee + $taxTotal);

            $order->update([
                'subtotal' => $subtotal,
                'discount_total' => $discount,
                'shipping_fee' => $shippingFee,
                'tax_total' => $taxTotal,
                'grand_total' => $grandTotal,
            ]);

            $payment = Payment::factory()->create([
                'order_id' => $order->id,
                'amount' => $grandTotal,
            ]);

            $shipment = Shipment::factory()->create([
                'order_id' => $order->id,
            ]);

            if ($payment->status === 'paid' && $shipment->status === 'delivered') {
                $order->update([
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'shipping_status' => 'delivered',
                ]);

                $lineItems->take(rand(0, $lineItems->count()))->each(function (OrderItem $item) use ($customer): void {
                    Review::factory()->create([
                        'user_id' => $customer->id,
                        'product_id' => $item->product_id,
                        'order_item_id' => $item->id,
                    ]);
                });
            }

            if ($usedCoupon) {
                CouponUsage::factory()->create([
                    'coupon_id' => $usedCoupon->id,
                    'user_id' => $customer->id,
                    'order_id' => $order->id,
                    'discount_amount' => $discount,
                ]);

                $usedCoupon->increment('used_count');
            }
        }
    }
}
