<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        try {
            DB::transaction(function () {
                $brands = $this->seedBrands();
                [$parents, $subs] = $this->seedCategories();
                $attributes = $this->seedAttributes();

                $this->attachAttributesToCategories($parents, $attributes);
                $this->seedProducts($brands, $parents, $subs, $attributes);
            });
        } finally {
            Model::reguard();
        }
    }

    /**
     * Keeps only the columns that really exist on the model's table, so the
     * seeder doesn't break on optional columns (slug, status, sort_order...).
     */
    private function only(string $modelClass, array $data): array
    {
        $table = (new $modelClass)->getTable();

        return array_filter(
            $data,
            fn($value, $column) => Schema::hasColumn($table, $column),
            ARRAY_FILTER_USE_BOTH
        );
    }

    /* ─────────────────────────── Brands ─────────────────────────── */

    private function seedBrands(): array
    {
        $names = [
            'Dell',
            'Lenovo',
            'HP',
            'Apple',
            'Asus',
            'Acer',
            'Samsung',
            'OnePlus',
            'Google',
            'Xiaomi',
            'Realme',
            'Motorola',
            'Vivo',
            'Logitech',
            'Crucial',
            'Redragon',
            'VANSH',
        ];

        $ids = [];

        foreach ($names as $name) {
            $brand = Brand::firstOrCreate(
                ['name' => $name],
                $this->only(Brand::class, ['status' => 1])
            );

            $ids[$name] = $brand->id;
        }

        return $ids;
    }

    /* ───────────────────────── Categories ───────────────────────── */

    private function seedCategories(): array
    {
        $defs = [
            'laptops' => [
                'name' => 'Laptops',
                'icon' => 'fa-laptop',
                'sub_title' => 'Refurbished & new laptops — Dell, ThinkPad, HP, Apple',
            ],
            'mobile-phones' => [
                'name' => 'Mobile Phones',
                'icon' => 'fa-mobile-screen-button',
                'sub_title' => 'Certified smartphones with 85%+ battery health',
            ],
            'accessories' => [
                'name' => 'Accessories',
                'icon' => 'fa-plug',
                'sub_title' => 'Chargers, storage, peripherals and more',
            ],
        ];

        $parents = [];
        $subs = [];
        $order = 1;

        foreach ($defs as $slug => $def) {
            $parent = Category::updateOrCreate(
                ['slug' => $slug],
                $this->only(Category::class, [
                    'name' => $def['name'],
                    'parent_id' => null,
                    'icon' => $def['icon'],
                    'sub_title' => $def['sub_title'],
                    'status' => 1,
                    'sort_order' => $order++,
                ])
            );

            $parents[$slug] = $parent;

        }

        return [$parents, $subs];
    }

    /* ───────────────────────── Attributes ───────────────────────── */


    private function seedAttributes(): array
    {
        $defs = [
            'Processor' => [
                'icon' => 'fa-solid fa-microchip',
                'values' => ['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'AMD Ryzen 3', 'Apple M1'],
            ],
            'RAM' => [
                'icon' => 'fa-solid fa-memory',
                'values' => ['4 GB', '6 GB', '8 GB', '16 GB', '32 GB'],
            ],
            'Storage' => [
                'icon' => 'fa-solid fa-hard-drive',
                'values' => ['64 GB', '128 GB', '256 GB', '512 GB', '1 TB'],
            ],
            'Screen Size' => [
                'icon' => 'fa-solid fa-display',
                'values' => ['13.3 inch', '14 inch', '15.6 inch', '16 inch'],
            ],
            'Operating System' => [
                'icon' => 'fa-solid fa-layer-group',
                'values' => ['Windows 10', 'Windows 11', 'macOS', 'Android', 'iOS'],
            ],

            // Accessories
            'Highlight' => [
                'icon' => 'fa-solid fa-bolt',
                'values' => [
                    '65W GaN Fast Charging',
                    'Silent Wireless',
                    '6-Level Height Adjust',
                    '3500 MB/s NVMe',
                    'DDR4 3200 MHz',
                    'Waterproof 25L',
                    'RGB Mechanical',
                    '20000 mAh Fast Charge',
                    '30dB Active Noise Cancelling',
                    'Dual Fan Cooling',
                ],
            ],
            'Type' => [
                'icon' => 'fa-solid fa-tag',
                'values' => [
                    'Charger',
                    'Mouse',
                    'Laptop Stand',
                    'SSD',
                    'RAM Module',
                    'Backpack',
                    'Keyboard',
                    'Power Bank',
                    'Earbuds',
                    'Cooling Pad',
                ],
            ],
        ];

        $result = [];
        $order = 1;

        foreach ($defs as $name => $def) {
            $attribute = Attribute::updateOrCreate(
                ['name' => $name],
                $this->only(Attribute::class, [
                    'slug' => Str::slug($name),
                    'icon' => $def['icon'],
                    'has_values' => 1,
                    'status' => 1,
                    'sort_order' => $order++,
                ])
            );

            $result[$name] = ['model' => $attribute, 'values' => []];

            foreach ($def['values'] as $i => $value) {
                $valueModel = AttributeValue::firstOrCreate(
                    ['attribute_id' => $attribute->id, 'value' => $value],
                    $this->only(AttributeValue::class, [
                        'status' => 1,
                        'sort_order' => $i + 1,
                    ])
                );

                $result[$name]['values'][$value] = $valueModel;
            }
        }

        return $result;
    }

    /* ─────────────── Attach attributes to categories ─────────────── */


    private function attachAttributesToCategories(array $parents, array $attributes): void
    {
        // attribute => [show_on_listing, show_in_filter]
        // Array order = sort_order. The FIRST listing attribute is shown on its own
        // line in the product card, the rest sit side by side underneath.
        $map = [
            'laptops' => [
                'Processor' => [true, true],
                'RAM' => [true, true],
                'Storage' => [true, true],
                'Screen Size' => [true, true],
                'Operating System' => [false, true],
            ],
            'mobile-phones' => [
                'RAM' => [true, true],
                'Storage' => [true, true],
                'Operating System' => [true, true],
            ],
            'accessories' => [
                'Highlight' => [true, false],
                'Type' => [true, true],
            ],
        ];

        foreach ($map as $categorySlug => $attrs) {
            $order = 0;

            foreach ($attrs as $attributeName => [$onListing, $inFilter]) {
                CategoryAttribute::updateOrCreate(
                    [
                        'category_id' => $parents[$categorySlug]->id,
                        'attribute_id' => $attributes[$attributeName]['model']->id,
                    ],
                    $this->only(CategoryAttribute::class, [
                        // attach only — nothing is dependent / variant yet
                        'used_for_variant' => 0,
                        'price_dependent' => 0,
                        'image_dependent' => 0,
                        'stock_dependent' => 0,
                        'sku_dependent' => 0,
                        'is_selectable' => 0,

                        'show_on_listing' => (int) $onListing,
                        'show_in_filter' => (int) $inFilter,

                        'status' => 1,
                        'sort_order' => ++$order,
                    ])
                );
            }
        }
    }

    /* ───────────────────────── Products ───────────────────────── */

    private function seedProducts(array $brands, array $parents, array $subs, array $attributes): void
    {
        foreach ($this->productData() as $categorySlug => $rows) {

            foreach ($rows as $row) {

                $isNew = $row['condition'] === 'New';
                $slug = Str::slug($row['name']);
                $discount = max(0, $row['mrp'] - $row['price']);

                $product = Product::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $parents[$categorySlug]->id,
                        'brand_id' => $brands[$row['brand']],

                        'name' => $row['name'],
                        'sku' => 'VIC-' . $row['code'],

                        'short_description' => $row['desc'],
                        'description' => '<p>' . e($row['desc']) . '</p>',

                        'condition' => $row['condition'],
                        'warranty' => $row['warranty'],
                        'condition_details' => $isNew ? null : $this->conditionHtml(),
                        'warranty_coverage' => $this->warrantyHtml(),
                        'shipping_delivery' => $this->shippingHtml(),

                        'key_specs' => array_map(
                            fn($s) => ['label' => $s[0], 'value' => $s[1]],
                            $row['specs']
                        ),

                        'warranty_backed' => true,
                        'seven_day_returns' => true,
                        'insured_transit' => true,
                        'video_call_demo' => true,

                        'mrp' => $row['mrp'],
                        'discount_type' => 'amount',
                        'discount' => $discount,
                        'price' => $row['price'],

                        'stock' => 10,
                        'min_qty' => 1,
                        'delivery_time' => '3–5 business days',

                        'quality' => !$isNew,
                        'pan_india' => true,

                        'meta_title' => $row['name'] . ' | VANSH IT & COMM',
                        'meta_description' => Str::limit($row['desc'], 155),

                        'status' => true,
                    ]
                );

                // Attach attribute values (no variants / dependencies)
                foreach ($row['attrs'] ?? [] as $attributeName => $value) {
                    ProductAttributeValue::firstOrCreate([
                        'product_id' => $product->id,
                        'attribute_id' => $attributes[$attributeName]['model']->id,
                        'attribute_value_id' => $attributes[$attributeName]['values'][$value]->id,
                    ]);
                }
            }
        }
    }

    /* ─────────────────────── Shared HTML blocks ─────────────────────── */

    private function conditionHtml(): string
    {
        return '<p>Each unit is physically evaluated by senior technicians and stress-tested with industrial benchmark tools.</p>'
            . '<h4>Core Computing</h4><ul>'
            . '<li>CPU / GPU thermal stress test</li>'
            . '<li>RAM MemTest86 100% stability</li>'
            . '<li>SSD SMART health &amp; speeds</li>'
            . '<li>Motherboard voltage integrity</li></ul>'
            . '<h4>Display &amp; Optics</h4><ul>'
            . '<li>Zero pixel &amp; bleed audit</li>'
            . '<li>Brightness &amp; uniformity check</li>'
            . '<li>Front / rear HD camera test</li>'
            . '<li>True Tone &amp; light sensors</li></ul>'
            . '<h4>Power &amp; Ports</h4><ul>'
            . '<li>85%+ certified battery capacity</li>'
            . '<li>USB-C &amp; Thunderbolt ports</li>'
            . '<li>Keyboard all-key feedback</li>'
            . '<li>Wi-Fi 6 &amp; dual microphones</li></ul>';
    }

    private function warrantyHtml(): string
    {
        return '<p>This product includes warranty as specified on the invoice and product listing. It covers internal hardware faults, motherboard defects, and component failure during normal operational use.</p>'
            . '<h4>How to claim warranty support?</h4>'
            . '<p>Simply message our support desk with your invoice number and a video demonstration of the issue. Our technicians will guide repair or replacement within 3 to 7 working days.</p>';
    }

    private function shippingHtml(): string
    {
        return '<p>Orders are dispatched within 24 hours of confirmation through top-tier courier services (BlueDart, Delhivery, DTDC) with end-to-end live tracking.</p>';
    }

    /* ───────────────────────── Product data ───────────────────────── */

    private function productData(): array
    {
        return [

            /* ══════════════════════ LAPTOPS ══════════════════════ */
            'laptops' => [
                [
                    'code' => 'LAP-01',
                    'sub' => 'business',
                    'brand' => 'Dell',
                    'name' => 'Dell Latitude 5420 Business Laptop',
                    'condition' => 'Refurbished',
                    'price' => 32499,
                    'mrp' => 89999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Enterprise-grade Dell Latitude 5420 meticulously tested across 20 quality points. Features durable carbon fiber chassis, thunderbolt ports, backlit keyboard, and pristine battery performance for professional productivity.',
                    'specs' => [
                        ['Processor', 'Intel Core i5 11th Gen (1145G7)'],
                        ['Display', '14" Full HD Anti-Glare (1920x1080)'],
                        ['Graphics', 'Intel Iris Xe Graphics'],
                        ['Battery', '88% (4-6 Hrs Backup)'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i5', 'RAM' => '16 GB', 'Storage' => '512 GB', 'Screen Size' => '14 inch', 'Operating System' => 'Windows 11'],
                ],
                [
                    'code' => 'LAP-02',
                    'sub' => 'coding',
                    'brand' => 'Lenovo',
                    'name' => 'Lenovo ThinkPad T480 Ultrabook',
                    'condition' => 'Refurbished',
                    'price' => 21999,
                    'mrp' => 74999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'The legendary developer favorite ThinkPad T480 with world-class ergonomic keyboard, legendary dual bridge battery, robust military-spec durability, and seamless Linux/Windows dual boot readiness.',
                    'specs' => [
                        ['Processor', 'Intel Core i5 8th Gen Quad-Core'],
                        ['Display', '14" Full HD IPS Display'],
                        ['Graphics', 'Intel UHD Graphics 620'],
                        ['Battery', '85% Dual Battery System'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i5', 'RAM' => '16 GB', 'Storage' => '256 GB', 'Screen Size' => '14 inch', 'Operating System' => 'Windows 11'],
                ],
                [
                    'code' => 'LAP-03',
                    'sub' => 'students',
                    'brand' => 'Apple',
                    'name' => 'Apple MacBook Air M1 (2020)',
                    'condition' => 'Refurbished',
                    'price' => 54999,
                    'mrp' => 99900,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Iconic silent fanless performance with lightning fast Apple M1 chip. Immaculate body condition, pristine Retina screen, 100% genuine original charger included.',
                    'specs' => [
                        ['Processor', 'Apple Silicon M1 (8-core CPU)'],
                        ['Display', '13.3" Retina Display with True Tone'],
                        ['Graphics', '7-core GPU'],
                        ['Battery', '92% Battery Health (12+ Hrs)'],
                    ],
                    'attrs' => ['Processor' => 'Apple M1', 'RAM' => '8 GB', 'Storage' => '256 GB', 'Screen Size' => '13.3 inch', 'Operating System' => 'macOS'],
                ],
                [
                    'code' => 'LAP-04',
                    'sub' => 'business',
                    'brand' => 'HP',
                    'name' => 'HP EliteBook 840 G6 Ultrabook',
                    'condition' => 'Refurbished',
                    'price' => 24999,
                    'mrp' => 82000,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Sleek silver all-metal CNC aluminum design with Bang & Olufsen tuned quad speakers, privacy shutter webcam, and ultra-fast NVMe storage for corporate power users.',
                    'specs' => [
                        ['Processor', 'Intel Core i5 8th Gen (8365U)'],
                        ['Display', '14" Full HD Slim IPS'],
                        ['Graphics', 'Intel UHD 620'],
                        ['Battery', '87% Health'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i5', 'RAM' => '16 GB', 'Storage' => '512 GB', 'Screen Size' => '14 inch', 'Operating System' => 'Windows 11'],
                ],
                [
                    'code' => 'LAP-05',
                    'sub' => 'students',
                    'brand' => 'Lenovo',
                    'name' => 'Lenovo IdeaPad 3 Slim Student Laptop',
                    'condition' => 'Refurbished',
                    'price' => 14499,
                    'mrp' => 38990,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Perfect high-value laptop for online classes, school projects, office spreadsheets, and video streaming with full numeric keypad and fast SSD boot times.',
                    'specs' => [
                        ['Processor', 'AMD Ryzen 3 3250U Dual Core'],
                        ['Display', '15.6" HD Anti-Glare'],
                        ['Graphics', 'AMD Radeon Vega 3'],
                        ['Battery', '89% Health'],
                    ],
                    'attrs' => ['Processor' => 'AMD Ryzen 3', 'RAM' => '8 GB', 'Storage' => '256 GB', 'Screen Size' => '15.6 inch', 'Operating System' => 'Windows 10'],
                ],
                [
                    'code' => 'LAP-06',
                    'sub' => 'gaming',
                    'brand' => 'Asus',
                    'name' => 'Asus TUF Gaming F15',
                    'condition' => 'Open Box',
                    'price' => 48999,
                    'mrp' => 75990,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'High-performance gaming machine ready for AAA gaming, 3D rendering, video editing, and simulations with dual self-cleaning fans and RGB keyboard.',
                    'specs' => [
                        ['Processor', 'Intel Core i5 11th Gen 11400H'],
                        ['Display', '15.6" FHD 144Hz IPS Level'],
                        ['Graphics', 'NVIDIA GeForce RTX 3050 4GB'],
                        ['Battery', '100% (Open Box Unused)'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i5', 'RAM' => '16 GB', 'Storage' => '512 GB', 'Screen Size' => '15.6 inch', 'Operating System' => 'Windows 11'],
                ],
                [
                    'code' => 'LAP-07',
                    'sub' => 'design',
                    'brand' => 'Dell',
                    'name' => 'Dell Precision 3530 Workstation',
                    'condition' => 'Refurbished',
                    'price' => 34999,
                    'mrp' => 115000,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Certified ISV mobile workstation built for AutoCAD, SolidWorks, Revit, Adobe Premiere, and heavy multitasking with immense 32GB RAM.',
                    'specs' => [
                        ['Processor', 'Intel Core i7 8th Gen 6-Core'],
                        ['Display', '15.6" FHD PremierColor IPS'],
                        ['Graphics', 'NVIDIA Quadro P600 4GB Dedicated'],
                        ['Battery', '86% Health'],
                        ['Storage Detail', '512 GB SSD + 1 TB HDD'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i7', 'RAM' => '32 GB', 'Storage' => '512 GB', 'Screen Size' => '15.6 inch', 'Operating System' => 'Windows 11'],
                ],
                [
                    'code' => 'LAP-08',
                    'sub' => 'everyday',
                    'brand' => 'Acer',
                    'name' => 'Acer Aspire 5 Slim Notebook',
                    'condition' => 'Refurbished',
                    'price' => 18999,
                    'mrp' => 46990,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Crisp 1080p screen, lightweight body, and super fast boot times makes this Acer Aspire 5 a dependable daily driver for home and remote work.',
                    'specs' => [
                        ['Processor', 'Intel Core i3 10th Gen'],
                        ['Display', '15.6" Full HD Narrow Bezel'],
                        ['Graphics', 'Intel UHD Graphics'],
                        ['Battery', '90% Health'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i3', 'RAM' => '8 GB', 'Storage' => '256 GB', 'Screen Size' => '15.6 inch', 'Operating System' => 'Windows 11'],
                ],
                [
                    'code' => 'LAP-09',
                    'sub' => 'design',
                    'brand' => 'Apple',
                    'name' => 'Apple MacBook Pro 16" TouchBar',
                    'condition' => 'Refurbished',
                    'price' => 68999,
                    'mrp' => 199900,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Monumental 6-speaker sound system with studio quality mics, expansive 16-inch high-density Retina screen, and dedicated Radeon Pro graphics for audio/video creators.',
                    'specs' => [
                        ['Processor', 'Intel Core i7 9th Gen 6-Core 2.6GHz'],
                        ['Display', '16" Retina Display (3072x1920)'],
                        ['Graphics', 'AMD Radeon Pro 5300M 4GB'],
                        ['Battery', '89% (Original cycle count verified)'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i7', 'RAM' => '16 GB', 'Storage' => '512 GB', 'Screen Size' => '16 inch', 'Operating System' => 'macOS'],
                ],
                [
                    'code' => 'LAP-10',
                    'sub' => 'students',
                    'brand' => 'Dell',
                    'name' => 'Dell Inspiron 3501 Core i3',
                    'condition' => 'Refurbished',
                    'price' => 14999,
                    'mrp' => 41000,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Massive dual storage combination with snappy SSD speed for OS plus 1TB space for photos, movies and study materials. Fully tested with zero faults.',
                    'specs' => [
                        ['Processor', 'Intel Core i3 10th Gen'],
                        ['Display', '15.6" Anti-Glare LED Display'],
                        ['Graphics', 'Intel UHD Graphics'],
                        ['Battery', '86% Health'],
                        ['Storage Detail', '128 GB SSD + 1 TB HDD'],
                    ],
                    'attrs' => ['Processor' => 'Intel Core i3', 'RAM' => '8 GB', 'Storage' => '128 GB', 'Screen Size' => '15.6 inch', 'Operating System' => 'Windows 10'],
                ],
            ],

            /* ══════════════════════ MOBILE PHONES ══════════════════════ */
            'mobile-phones' => [
                [
                    'code' => 'MOB-01',
                    'sub' => 'premium',
                    'brand' => 'Apple',
                    'name' => 'Apple iPhone 13 (128 GB)',
                    'condition' => 'Refurbished',
                    'price' => 38999,
                    'mrp' => 59900,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Flawless cosmetic condition iPhone 13. Features sensor-shift optical image stabilization, ceramic shield front glass, 5G connectivity and all original OEM hardware.',
                    'specs' => [
                        ['Processor', 'A15 Bionic Chip (5nm)'],
                        ['Display', '6.1" Super Retina XDR OLED'],
                        ['Camera', '12MP + 12MP Cinematic Mode 4K'],
                        ['Battery', '89% Battery Health (Verified)'],
                    ],
                    'attrs' => ['RAM' => '4 GB', 'Storage' => '128 GB', 'Operating System' => 'iOS'],
                ],
                [
                    'code' => 'MOB-02',
                    'sub' => 'premium',
                    'brand' => 'Samsung',
                    'name' => 'Samsung Galaxy S22 5G (8GB / 128GB)',
                    'condition' => 'Refurbished',
                    'price' => 28999,
                    'mrp' => 72999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Compact premium flagship with nightography camera sensor, Armor Aluminum frame, 120Hz silky smooth AMOLED display, and full IP68 water resistance.',
                    'specs' => [
                        ['Processor', 'Snapdragon 8 Gen 1 (4nm)'],
                        ['Display', '6.1" Dynamic AMOLED 2X 120Hz'],
                        ['Camera', '50MP + 10MP (3x Zoom) + 12MP Ultra Wide'],
                        ['Battery', '91% Battery Health'],
                    ],
                    'attrs' => ['RAM' => '8 GB', 'Storage' => '128 GB', 'Operating System' => 'Android'],
                ],
                [
                    'code' => 'MOB-03',
                    'sub' => 'gaming',
                    'brand' => 'OnePlus',
                    'name' => 'OnePlus 11R 5G (8GB / 128GB)',
                    'condition' => 'Open Box',
                    'price' => 24999,
                    'mrp' => 39999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Unmatched gaming performance with 100W blazing fast charging (0 to 100% in 25 mins), flagship IMX890 camera sensor and alert slider.',
                    'specs' => [
                        ['Processor', 'Snapdragon 8+ Gen 1 Flagship'],
                        ['Display', '6.74" Super Fluid AMOLED 120Hz'],
                        ['Camera', '50MP Sony IMX890 OIS'],
                        ['Battery', '100% (100W SUPERVOOC Charger Included)'],
                    ],
                    'attrs' => ['RAM' => '8 GB', 'Storage' => '128 GB', 'Operating System' => 'Android'],
                ],
                [
                    'code' => 'MOB-04',
                    'sub' => 'photography',
                    'brand' => 'Google',
                    'name' => 'Google Pixel 7 5G (8GB / 128GB)',
                    'condition' => 'Refurbished',
                    'price' => 26999,
                    'mrp' => 59999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'The ultimate computational photography phone with Magic Eraser, Real Tone skin tone accuracy, photo unblur, and guaranteed direct Android updates.',
                    'specs' => [
                        ['Processor', 'Google Tensor G2 with Titan M2'],
                        ['Display', '6.3" FHD+ OLED 90Hz HDR10+'],
                        ['Camera', '50MP Octa PD Quad Bayer + 12MP Ultra-wide'],
                        ['Battery', '92% Battery Health'],
                    ],
                    'attrs' => ['RAM' => '8 GB', 'Storage' => '128 GB', 'Operating System' => 'Android'],
                ],
                [
                    'code' => 'MOB-05',
                    'sub' => 'everyday',
                    'brand' => 'Xiaomi',
                    'name' => 'Xiaomi Redmi Note 12 Pro 5G',
                    'condition' => 'Refurbished',
                    'price' => 13999,
                    'mrp' => 27999,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Outstanding mid-range performer featuring flagship Sony IMX766 sensor with OIS, 67W turbo charging, and stunning 120Hz Dolby Vision AMOLED screen.',
                    'specs' => [
                        ['Processor', 'MediaTek Dimensity 1080 5G'],
                        ['Display', '6.67" Pro AMOLED 120Hz Dolby Vision'],
                        ['Camera', '50MP Sony IMX766 OIS Camera'],
                        ['Battery', '90% (5000mAh Battery)'],
                    ],
                    'attrs' => ['RAM' => '6 GB', 'Storage' => '128 GB', 'Operating System' => 'Android'],
                ],
                [
                    'code' => 'MOB-06',
                    'sub' => 'students',
                    'brand' => 'Realme',
                    'name' => 'Realme Narzo 50A Prime',
                    'condition' => 'Refurbished',
                    'price' => 6999,
                    'mrp' => 14499,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Ultra-affordable reliable phone with crisp 1080p high-resolution screen, massive all-day 5000mAh battery, and sharp 50MP AI primary camera.',
                    'specs' => [
                        ['Processor', 'Unisoc T612 Octa-core'],
                        ['Display', '6.6" FHD+ Fullscreen Display'],
                        ['Camera', '50MP AI Triple Camera'],
                        ['Battery', '94% (5000mAh Massive Battery)'],
                    ],
                    'attrs' => ['RAM' => '4 GB', 'Storage' => '64 GB', 'Operating System' => 'Android'],
                ],
                [
                    'code' => 'MOB-07',
                    'sub' => 'everyday',
                    'brand' => 'Motorola',
                    'name' => 'Motorola Moto G73 5G',
                    'condition' => 'Refurbished',
                    'price' => 11499,
                    'mrp' => 21999,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Ad-free clean stock Android experience with 13 5G bands support, stereo speakers with Dolby Atmos, and massive 8GB RAM for zero stutter multitasking.',
                    'specs' => [
                        ['Processor', 'MediaTek Dimensity 930 5G'],
                        ['Display', '6.5" FHD+ 120Hz Ultra Smooth'],
                        ['Camera', '50MP 2.0um Ultra Pixel + 8MP Macro/Wide'],
                        ['Battery', '91% (5000mAh Battery)'],
                    ],
                    'attrs' => ['RAM' => '8 GB', 'Storage' => '128 GB', 'Operating System' => 'Android'],
                ],
                [
                    'code' => 'MOB-08',
                    'sub' => 'premium',
                    'brand' => 'Apple',
                    'name' => 'Apple iPhone 11 (64 GB)',
                    'condition' => 'Refurbished',
                    'price' => 21499,
                    'mrp' => 49900,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'The most popular entry point into the Apple ecosystem. Durable glass design, water resistance, 4K 60fps video recording on all lenses, and all-day battery.',
                    'specs' => [
                        ['Processor', 'A13 Bionic 3rd Gen Neural Engine'],
                        ['Display', '6.1" Liquid Retina HD Display'],
                        ['Camera', '12MP Ultra-Wide and Wide with Night Mode'],
                        ['Battery', '87% Original Battery Health'],
                    ],
                    'attrs' => ['RAM' => '4 GB', 'Storage' => '64 GB', 'Operating System' => 'iOS'],
                ],
                [
                    'code' => 'MOB-09',
                    'sub' => 'everyday',
                    'brand' => 'Samsung',
                    'name' => 'Samsung Galaxy M34 5G (6GB / 128GB)',
                    'condition' => 'Refurbished',
                    'price' => 12499,
                    'mrp' => 24499,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Monster 6000mAh battery that easily lasts 2 full days on single charge, paired with vibrant 120Hz Super AMOLED display and OIS camera.',
                    'specs' => [
                        ['Processor', 'Exynos 1280 5nm Octa-Core'],
                        ['Display', '6.5" Super AMOLED 120Hz Gorilla Glass 5'],
                        ['Camera', '50MP No Shake OIS Camera'],
                        ['Battery', '93% (Monster 6000mAh Battery)'],
                    ],
                    'attrs' => ['RAM' => '6 GB', 'Storage' => '128 GB', 'Operating System' => 'Android'],
                ],
                [
                    'code' => 'MOB-10',
                    'sub' => 'students',
                    'brand' => 'Vivo',
                    'name' => 'Vivo T2x 5G (6GB / 128GB)',
                    'condition' => 'Refurbished',
                    'price' => 9999,
                    'mrp' => 18999,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Top-tier 5G smartphone under ₹10,000 with 6GB physical RAM + 6GB virtual RAM expansion, slim matte finish body, and crystal clear night camera.',
                    'specs' => [
                        ['Processor', 'MediaTek Dimensity 6020 7nm 5G'],
                        ['Display', '6.58" FHD+ Ultra Smooth Screen'],
                        ['Camera', '50MP Super Night Camera'],
                        ['Battery', '92% (5000mAh Battery)'],
                    ],
                    'attrs' => ['RAM' => '6 GB', 'Storage' => '128 GB', 'Operating System' => 'Android'],
                ],
            ],

            /* ══════════════════════ ACCESSORIES ══════════════════════ */
            'accessories' => [
                [
                    'code' => 'ACC-01',
                    'sub' => 'chargers',
                    'brand' => 'VANSH',
                    'name' => '65W GaN Fast Charger 3-Port (Type-C + USB-A)',
                    'condition' => 'New',
                    'price' => 1299,
                    'mrp' => 2999,
                    'warranty' => '12 Month Replacement Warranty',
                    'desc' => 'Compact Gallium Nitride (GaN) fast charger capable of charging your laptop and two smartphones simultaneously at full speed with built-in surge protection.',
                    'specs' => [
                        ['Compatibility', 'MacBook, Dell, HP, ThinkPad, iPhone, Android'],
                        ['Ports', '2x USB-C PD 3.0 + 1x USB-A QC 3.0'],
                    ],
                ],
                [
                    'code' => 'ACC-02',
                    'sub' => 'peripherals',
                    'brand' => 'Logitech',
                    'name' => 'Wireless Ergonomic Silent Optical Mouse',
                    'condition' => 'New',
                    'price' => 899,
                    'mrp' => 1995,
                    'warranty' => '12 Month Warranty',
                    'desc' => '90% noise reduced silent clicks with natural contoured grip designed to prevent wrist fatigue during long office or coding sessions.',
                    'specs' => [
                        ['Connectivity', '2.4GHz Wireless Nano Receiver + Bluetooth 5.0'],
                        ['Battery Life', 'Up to 18 Months on single AA'],
                    ],
                ],
                [
                    'code' => 'ACC-03',
                    'sub' => 'stands',
                    'brand' => 'VANSH',
                    'name' => 'Aluminum Ergonomic Adjustable Laptop Stand',
                    'condition' => 'New',
                    'price' => 799,
                    'mrp' => 1999,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Heavy duty foldable laptop stand providing optimal eye level posture and open hollow design for maximum airflow cooling.',
                    'specs' => [
                        ['Material', 'Premium Sandblasted Aluminum Alloy'],
                        ['Adjustability', '6-level height adjustment (10° to 45°)'],
                    ],
                ],
                [
                    'code' => 'ACC-04',
                    'sub' => 'storage',
                    'brand' => 'Crucial',
                    'name' => 'Crucial 500GB NVMe M.2 High-Speed SSD',
                    'condition' => 'New',
                    'price' => 2799,
                    'mrp' => 4500,
                    'warranty' => '3 Year Manufacturer Warranty',
                    'desc' => 'Instant upgrade for any slow laptop or PC. 6x faster than SATA SSDs, allowing sub-10 second boot times and instant game loading.',
                    'specs' => [
                        ['Speed', 'Up to 3500 MB/s Read Speed (PCIe Gen3 x4)'],
                        ['Form Factor', 'M.2 2280'],
                    ],
                ],
                [
                    'code' => 'ACC-05',
                    'sub' => 'storage',
                    'brand' => 'Samsung',
                    'name' => '16GB DDR4 3200MHz Laptop RAM Module',
                    'condition' => 'New',
                    'price' => 2499,
                    'mrp' => 4999,
                    'warranty' => '3 Year Warranty',
                    'desc' => 'Double your memory to run Chrome with 50+ tabs, video editors, and IDEs smoothly without lag or throttling.',
                    'specs' => [
                        ['Speed', '3200 MT/s SO-DIMM 260-Pin'],
                        ['Compatibility', 'Intel & AMD Laptops'],
                    ],
                ],
                [
                    'code' => 'ACC-06',
                    'sub' => 'bags',
                    'brand' => 'VANSH',
                    'name' => 'Waterproof Anti-Theft Laptop Backpack (15.6")',
                    'condition' => 'New',
                    'price' => 1199,
                    'mrp' => 2999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Cushioned air-mesh back padding, hidden zipper security, and water repellent material ideal for daily office commuting and travel.',
                    'specs' => [
                        ['Capacity', '25L with dedicated padded laptop compartment'],
                        ['Features', 'External USB charging port + Waterproof Oxford fabric'],
                    ],
                ],
                [
                    'code' => 'ACC-07',
                    'sub' => 'peripherals',
                    'brand' => 'Redragon',
                    'name' => 'RGB Gaming Mechanical Keyboard (Blue Switches)',
                    'condition' => 'New',
                    'price' => 1999,
                    'mrp' => 3999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Tactile satisfying typing feedback with 100% anti-ghosting N-key rollover and solid aluminum top plate construction.',
                    'specs' => [
                        ['Switches', 'Dust-proof Clicky Blue Mechanical Switches'],
                        ['Backlight', '18 Preset RGB Lighting Modes with brightness control'],
                    ],
                ],
                [
                    'code' => 'ACC-08',
                    'sub' => 'chargers',
                    'brand' => 'Xiaomi',
                    'name' => '20,000mAh 22.5W Fast Charging Power Bank',
                    'condition' => 'New',
                    'price' => 1699,
                    'mrp' => 2999,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Charges a typical smartphone 4 to 5 times. Features 12-layer advanced circuit chip protection and low current mode for earbuds.',
                    'specs' => [
                        ['Capacity', '20,000mAh High-Density Lithium Polymer'],
                        ['Output', '22.5W Two-way Quick Charge with Type-C input/output'],
                    ],
                ],
                [
                    'code' => 'ACC-09',
                    'sub' => 'audio',
                    'brand' => 'Realme',
                    'name' => 'Active Noise Cancelling Wireless Earbuds (ANC)',
                    'condition' => 'New',
                    'price' => 1899,
                    'mrp' => 3999,
                    'warranty' => '12 Month Warranty',
                    'desc' => 'Block out traffic and chatter with 30dB active noise cancellation. 12.4mm dynamic bass drivers for immersive punchy sound.',
                    'specs' => [
                        ['Noise Cancellation', '30dB Active Noise Cancellation + Transparency Mode'],
                        ['Battery', '38 Hours Total Playback with Fast Charging'],
                    ],
                ],
                [
                    'code' => 'ACC-10',
                    'sub' => 'stands',
                    'brand' => 'VANSH',
                    'name' => 'Dual Fan High Performance Laptop Cooling Pad',
                    'condition' => 'New',
                    'price' => 999,
                    'mrp' => 2499,
                    'warranty' => '6 Month Warranty',
                    'desc' => 'Drops laptop internal temperature by up to 12°C during intensive video rendering or gaming. Blue LED lighting and adjustable anti-skid baffles.',
                    'specs' => [
                        ['Fans', '2x 140mm Whisper Quiet LED Fans (1200 RPM)'],
                        ['Ports', 'Pass-through Dual USB Ports'],
                    ],
                ],
            ],
        ];
    }
}