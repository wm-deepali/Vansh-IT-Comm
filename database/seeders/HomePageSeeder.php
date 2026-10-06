<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class HomePageSeeder extends Seeder
{
    /** route name => *_route column, URL / #anchor => *_url column */
    private function link(string $prefix, ?string $v): array
    {
        if (!$v) return ["{$prefix}_route" => null, "{$prefix}_url" => null];
        $isUrl = preg_match('#^(https?://|/|\#)#', $v) || !Route::has($v);
        return [
            "{$prefix}_route" => $isUrl ? null : $v,
            "{$prefix}_url"   => $isUrl ? $v : null,
        ];
    }

    private function json($data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /** Insert only when the table is empty, so admin edits are never overwritten. */
    private function emptyTable(string $table): bool
    {
        return DB::table($table)->doesntExist();
    }

    public function run(): void
    {
        $this->headings();
        $this->slides();
        $this->features();
        $this->budget();
        $this->guided();
        $this->steps();
        $this->ctaBlocks();
        $this->stores();
    }

    private function headings(): void
    {
        // ⚠️ keys must match $headingKeys in HomePageController
        $rows = [
            'categories'      => ['Explore Collections', 'Shop By Category', 'Verified laptops, smartphones, accessories, and certified repair solutions.', 'View All Products', 'shop'],
            'featured_1'      => ['Featured Picks', 'Featured Laptops', null, 'Browse All', 'shop'],
            'budget'          => [null, 'Shop Laptops By Budget', null, null, null],
            'guided'          => ['Guided Recommendation', "What's Right For You?", 'Find the exact technology tailored to your performance, budget, and daily workflow.', null, null],
            'featured_2'      => ['Featured Picks', 'Featured Mobile Phones', null, 'Browse All', 'shop'],
            'accessories'     => ['Gear & Upgrades', 'Computer & Mobile Accessories', 'GaN fast chargers, NVMe SSDs, mechanical keyboards, ergonomic stands, and audio.', 'View All', 'shop'],
            'brands'          => ['Certified Technology Partners', 'Shop By Brand', 'Browse top laptop and smartphone manufacturers tested across 20 diagnostic points.', 'View All', 'shop'],
            'refurbish'       => ['Quality Control Protocol', 'How We Refurbish', 'Every device undergoes our strict 6-stage engineering and testing cycle.', null, null],
            'why_us'          => ['The Standard We Set', 'Why VANSH IT & COMM', 'Transparent condition, genuine components, and honest customer support.', null, null],
            'store_locations' => ['Physical Hub & Logistics', 'Store Locations & Hubs', 'Visit our experience store, service workshop, or track express dispatch centers.', 'View All Details →', 'contact'],
            'reviews'         => ['Trusted by Buyers', 'Customer Reviews', 'Sample feedback from verified customers across India.', null, null],
            'faq'             => ['Got Questions?', 'Frequently Asked Questions', 'Clear information regarding testing, warranty, returns, and repairs.', null, null],
        ];

        foreach ($rows as $key => [$eyebrow, $title, $sub, $lt, $link]) {
            // per-key, so adding a new key later still works
            if (DB::table('home_section_headings')->where('key', $key)->exists()) continue;
            DB::table('home_section_headings')->insert(array_merge([
                'key' => $key, 'eyebrow' => $eyebrow, 'title' => $title, 'subtitle' => $sub,
                'link_text' => $lt, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ], $this->link('link', $link)));
        }
    }

    private function slides(): void
    {
        if (!$this->emptyTable('home_hero_slides')) return;

        $slides = [
            [
                'badge_text' => 'Tested Technology. Trusted Value.', 'badge_icon' => 'fa-solid fa-bolt', 'theme' => 'blue',
                'title_line_1' => 'TECH THAT WORKS', 'title_highlight' => 'FOR YOU.',
                'description' => 'New & refurbished laptops, smartphones, and accessories. 20-point tested, transparent condition grading, and reliable warranty support from VANSH IT & COMM.',
                'btn_primary_text' => 'SHOP LAPTOPS', 'btn_primary_icon' => 'fa-solid fa-laptop', 'p' => 'shop',
                'btn_secondary_text' => 'SHOP MOBILES', 'btn_secondary_icon' => 'fa-solid fa-mobile-screen-button', 's' => 'shop',
                'link_text' => 'Need a Repair? Book Now →', 'l' => 'repair',
                'trust_points' => [
                    ['icon' => 'fa-solid fa-circle-check', 'color' => 'text-emerald-400', 'text' => 'Up to 12-Mo Warranty'],
                    ['icon' => 'fa-solid fa-truck-fast',   'color' => 'text-blue-400',    'text' => 'Pan-India Insured Parcel'],
                    ['icon' => 'fa-solid fa-file-invoice', 'color' => 'text-amber-400',   'text' => 'GST Input Credit'],
                ],
                'card_image' => 'assets/img/product-1593642632823-8f785ba67e45.jpg', 'card_image_alt' => 'Dell Latitude 5420 Business Laptop',
                'card_top_badge' => '🔥 Best Seller • 64% OFF', 'card_bottom_badge' => '20-Point Verified',
                'card_label' => 'Enterprise Grade', 'card_title' => 'Dell Latitude 5420 i5 11th Gen',
                'card_subtitle' => '16GB RAM • 512GB SSD • 14" FHD IPS', 'card_old_price' => '₹89,999', 'card_price' => '₹32,499',
            ],
            [
                'badge_text' => 'UP TO 70% SAVINGS', 'badge_icon' => 'fa-solid fa-percent', 'theme' => 'emerald',
                'title_line_1' => 'PREMIUM REFURBISHED', 'title_highlight' => 'BUSINESS LAPTOPS',
                'description' => 'Tested. Trusted. Ready to Work. Quality enterprise ThinkPads, MacBooks, and Dell Latitudes engineered for developers, students, and businesses starting from ₹14,499.',
                'btn_primary_text' => 'Shop Laptops', 'btn_primary_icon' => 'fa-solid fa-laptop', 'p' => 'shop',
                'btn_secondary_text' => 'Explore Deals', 'btn_secondary_icon' => 'fa-solid fa-fire', 's' => 'shop',
                'link_text' => 'Our 20-Point Checklist →', 'l' => '#how-we-refurbish',
                'trust_points' => [
                    ['icon' => 'fa-solid fa-circle-check',           'color' => 'text-emerald-400', 'text' => 'Grade A Flawless Body'],
                    ['icon' => 'fa-solid fa-battery-three-quarters', 'color' => 'text-emerald-400', 'text' => '80%+ Battery Health'],
                    ['icon' => 'fa-solid fa-rotate-left',            'color' => 'text-teal-400',    'text' => '7-Day Replacement'],
                ],
                'card_image' => 'assets/img/product-1588872657578-7efd1f1555ed.jpg', 'card_image_alt' => 'Lenovo ThinkPad T480s Business Laptop',
                'card_top_badge' => "⚡ Developer's Choice • 74% OFF", 'card_bottom_badge' => 'Original Charger Included',
                'card_label' => 'Refurbished Grade A', 'card_title' => 'Lenovo ThinkPad T480s i5 8th Gen',
                'card_subtitle' => '16GB RAM • 512GB SSD • Dual Battery', 'card_old_price' => '₹78,000', 'card_price' => '₹19,999',
            ],
            [
                'badge_text' => 'CERTIFIED SMARTPHONES', 'badge_icon' => 'fa-solid fa-mobile-screen', 'theme' => 'purple',
                'title_line_1' => 'NEW & REFURBISHED', 'title_highlight' => 'FLAGSHIP MOBILES',
                'description' => 'Upgrade to Apple iPhones, Samsung Galaxy S-Series, and OnePlus 5G flagships. 100% genuine parts, 85%+ battery health guarantee, and doorstep exchange bonus.',
                'btn_primary_text' => 'Shop Mobiles', 'btn_primary_icon' => 'fa-solid fa-mobile-screen-button', 'p' => 'shop',
                'btn_secondary_text' => 'Exchange Old Phone', 'btn_secondary_icon' => 'fa-solid fa-repeat', 's' => 'exchange',
                'link_text' => 'Warranty Coverage →', 'l' => 'policies',
                'trust_points' => [
                    ['icon' => 'fa-solid fa-circle-check',  'color' => 'text-purple-400', 'text' => '85%+ Battery Guarantee'],
                    ['icon' => 'fa-solid fa-shield-halved', 'color' => 'text-pink-400',   'text' => '6-Month Warranty'],
                    ['icon' => 'fa-solid fa-box-open',      'color' => 'text-purple-400', 'text' => 'Cable Included'],
                ],
                'card_image' => 'assets/img/product-1592750475338-74b7b21085ab.jpg', 'card_image_alt' => 'Apple iPhone 13 Certified Refurbished',
                'card_top_badge' => '🌟 Top Flagship • 47% OFF', 'card_bottom_badge' => '88% Battery Health',
                'card_label' => 'Certified Apple', 'card_title' => 'Apple iPhone 13 128GB Midnight',
                'card_subtitle' => 'Super Retina XDR • A15 Bionic • 5G', 'card_old_price' => '₹69,900', 'card_price' => '₹36,999',
            ],
        ];

        foreach ($slides as $i => $s) {
            [$p, $sec, $l] = [$s['p'], $s['s'], $s['l']];
            unset($s['p'], $s['s'], $s['l']);
            $s['trust_points'] = $this->json($s['trust_points']);

            DB::table('home_hero_slides')->insert(array_merge(
                $s,
                $this->link('btn_primary', $p),
                $this->link('btn_secondary', $sec),
                $this->link('link', $l),
                ['sort_order' => $i, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()]
            ));
        }
    }

    private function features(): void
    {
        $sets = [
            'trust_strip' => [
                ['fa-solid fa-clipboard-check', 'blue',    '20+ Point Tested', 'Hardware & screen verified'],
                ['fa-solid fa-receipt',         'emerald', 'GST Invoice',      'Claim 18% input credit'],
                ['fa-solid fa-shield-halved',   'purple',  'Warranty Covered', 'Up to 12-Mo protection'],
                ['fa-solid fa-box-open',        'amber',   'Secure Shipping',  'Pan-India insured parcel'],
                ['fa-solid fa-headset',         'sky',     'Expert Support',   'Direct technical help'],
            ],
            'why_us' => [
                ['fa-solid fa-shield-virus',           'blue',    '20+ Point Tested',     'Full diagnostic hardware evaluation.'],
                ['fa-solid fa-file-invoice',           'emerald', 'GST Tax Invoice',      'Claim 18% input credit for businesses.'],
                ['fa-solid fa-award',                  'purple',  'Warranty Included',    'Warranty as specified on product.'],
                ['fa-solid fa-battery-three-quarters', 'amber',   'Battery Health Check', '85%+ retention certified backup.'],
                ['fa-solid fa-truck-shield',           'sky',     'Secure Delivery',      'Insured logistics with tracking.'],
                ['fa-solid fa-headset',                'rose',    'Expert Support',       'Direct technical help when needed.'],
                ['fa-solid fa-magnifying-glass-chart', 'teal',    'Transparent Grading',  'Actual device photos upon request.'],
                ['fa-solid fa-hand-holding-dollar',    'indigo',  'Value Pricing',        'Up to 70% lower than brand new MRP.'],
            ],
        ];

        foreach ($sets as $section => $items) {
            if (DB::table('home_features')->where('section', $section)->exists()) continue;
            foreach ($items as $i => [$icon, $color, $title, $sub]) {
                DB::table('home_features')->insert([
                    'section' => $section, 'icon' => $icon, 'color' => $color,
                    'title' => $title, 'subtitle' => $sub,
                    'sort_order' => $i, 'is_active' => true,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }
    }

    private function budget(): void
    {
        if (!$this->emptyTable('home_budget_cards')) return;

        $rows = [
            ['Entry & Students',  'Laptops Under ₹15,000', 'Fast SSDs, ideal for online study, office docs, and browsing.',   null,  15000, 'from-blue-900 to-slate-900',   'text-emerald-400', 'bg-blue-600'],
            ['Most Popular',      'Laptops ₹15K – ₹25K',   'Core i5 8th Gen, 16GB RAM, ThinkPads & Dell Latitudes.',          15000, 25000, 'from-indigo-900 to-slate-900', 'text-blue-300',    'bg-indigo-600'],
            ['Pro & Developers',  'Laptops ₹25K – ₹35K',   'Core i5 11th Gen / M1 MacBooks with 512GB NVMe SSD.',             25000, 35000, 'from-slate-900 to-blue-950',   'text-amber-300',   'bg-slate-700'],
        ];

        foreach ($rows as $i => [$label, $title, $desc, $min, $max, $grad, $lc, $bc]) {
            DB::table('home_budget_cards')->insert([
                'label' => $label, 'title' => $title, 'description' => $desc,
                'min_price' => $min, 'max_price' => $max, 'button_text' => 'View Products →',
                'gradient' => $grad, 'label_color' => $lc, 'button_color' => $bc,
                'sort_order' => $i, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    private function guided(): void
    {
        if (!$this->emptyTable('home_guided_options')) return;

        $rows = [
            ['fa-solid fa-laptop', 'blue', 'High Performance', 'Need a Laptop?',
                'Tailored configurations for coding, business multitasking, CAD/design, and academic study.',
                ['<strong>8GB to 32GB</strong> RAM options', 'Fast NVMe SSD storage', '<strong>Up to 12-Month</strong> Warranty'],
                'Find My Laptop', 'shop'],
            ['fa-solid fa-mobile-screen-button', 'emerald', '5G & Flagships', 'Need a Phone?',
                'High-end camera sensors, long-lasting battery life, and vivid AMOLED 120Hz high refresh screens.',
                ['<strong>85%+ Verified</strong> Battery Health', '100% Original OEM components', '<strong>5G Connectivity</strong> & Dual SIM'],
                'Find My Phone', 'shop'],
            ['fa-solid fa-screwdriver-wrench', 'amber', 'Expert Service', 'Need a Repair?',
                'Expert diagnosis for screens, batteries, keyboards, charging ports, and OS speedup.',
                ['<strong>Transparent</strong> repair quotation', 'Quality tested replacement parts', '<strong>Quick turnaround</strong> times'],
                'Book Repair Service', 'repair'],
        ];

        foreach ($rows as $i => [$icon, $color, $badge, $title, $desc, $features, $btn, $link]) {
            DB::table('home_guided_options')->insert(array_merge([
                'icon' => $icon, 'color' => $color, 'badge' => $badge, 'title' => $title,
                'description' => $desc, 'features' => $this->json($features),
                'button_text' => $btn, 'sort_order' => $i, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ], $this->link('button', $link)));
        }
    }

    private function steps(): void
    {
        if (!$this->emptyTable('home_process_steps')) return;

        $rows = [
            ['Device Sourced', 'Corporate off-lease or open box origin check.',        'blue'],
            ['Inspection',     'Physical body, hinges, keyboard, port grading.',        'blue'],
            ['Hardware Test',  '20-Point Motherboard, RAM, SSD & battery stress test.', 'blue'],
            ['Thermal Clean',  'Fan dust clearing & thermal paste re-application.',     'blue'],
            ['QC & Software',  'Clean OS installation & genuine driver testing.',       'blue'],
            ['Dispatched',     'Multi-layer bubble pack with charger & warranty.',      'emerald'],
        ];

        foreach ($rows as $i => [$t, $d, $c]) {
            DB::table('home_process_steps')->insert([
                'title' => $t, 'description' => $d, 'color' => $c,
                'sort_order' => $i, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    private function ctaBlocks(): void
    {
        $blocks = [
            'brand_philosophy' => [
                'badge_text' => 'THE VANSH ADVANTAGE', 'title' => 'THE SMARTER WAY TO BUY TECH', 'description' => null,
                'buttons' => [1 => ['Explore All Offerings', 'fa-solid fa-arrow-right', 'shop']],
                'items' => [
                    ['icon' => 'fa-solid fa-circle-check', 'color' => 'text-blue-400',    'text' => '<strong>New</strong> when you want the latest release.'],
                    ['icon' => 'fa-solid fa-circle-check', 'color' => 'text-emerald-400', 'text' => '<strong>Refurbished</strong> when you want maximum value.'],
                    ['icon' => 'fa-solid fa-circle-check', 'color' => 'text-amber-400',   'text' => '<strong>Repair</strong> when you want to extend your device life.'],
                    ['icon' => 'fa-solid fa-circle-check', 'color' => 'text-purple-400',  'text' => "<strong>Exchange</strong> when you're ready for an upgrade."],
                ],
            ],
            'repair_cta' => [
                'badge_text' => 'PROFESSIONAL WORKSHOP', 'title' => 'Need a Laptop or Mobile Repair?',
                'description' => 'From screen replacements to charging issues, get professional device support. Tell us what went wrong and our team can help identify the right solution.',
                'buttons' => [
                    1 => ['Book a Repair',       'fa-solid fa-wrench',   'repair'],
                    2 => ['Talk to Technician',  'fa-solid fa-comments', 'contact'],
                ],
                'items' => [
                    ['icon' => 'fa-solid fa-display',      'color' => 'text-blue-400',   'text' => 'Laptop / Mobile Screen Replacement', 'tag' => 'Same Day Available'],
                    ['icon' => 'fa-solid fa-battery-half', 'color' => 'text-amber-400',  'text' => 'OEM Battery Replacement',            'tag' => 'Tested Capacity'],
                    ['icon' => 'fa-solid fa-bolt',         'color' => 'text-purple-400', 'text' => 'SSD / RAM Upgrade & Speed Boost',    'tag' => 'In 30 Minutes'],
                ],
            ],
            'exchange_cta' => [
                'badge_text' => 'UPGRADE PROGRAM', 'title' => 'Your Old Device. Your Next Upgrade.',
                'description' => 'Trade in your working or used laptop and smartphone to get instant credit towards any refurbished or new product.',
                'buttons' => [1 => ['Calculate Trade-In Value', 'fa-solid fa-calculator', 'exchange']],
                'items' => [],
            ],
            'final_cta' => [
                'badge_text' => 'BUY SMART. UPGRADE BETTER.', 'title' => 'READY TO UPGRADE?',
                'description' => 'Find the right device, get expert help, or give your current device a second life with VANSH IT & COMM.',
                'buttons' => [
                    1 => ['Explore Laptops', null, 'shop'],
                    2 => ['Explore Mobiles', null, 'shop'],
                    3 => ['Book a Repair',   null, 'repair'],
                ],
                'items' => [],
            ],
        ];

        foreach ($blocks as $key => $b) {
            if (DB::table('home_cta_blocks')->where('key', $key)->exists()) continue;

            $row = [
                'key' => $key, 'badge_text' => $b['badge_text'], 'title' => $b['title'],
                'description' => $b['description'], 'items' => $this->json($b['items']),
                'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ];
            foreach ($b['buttons'] as $n => [$text, $icon, $link]) {
                $row["btn_{$n}_text"] = $text;
                $row["btn_{$n}_icon"] = $icon;
                $row = array_merge($row, $this->link("btn_{$n}", $link));
            }
            DB::table('home_cta_blocks')->insert($row);
        }
    }

    private function stores(): void
    {
        if (!$this->emptyTable('home_store_locations')) return;

        $rows = [
            ['fa-solid fa-store', 'blue', 'Retail Store', 'Main Experience Store', '[Store location will be updated here.]', null,
                [['fa-regular fa-clock', 'Mon – Sat: 10:00 AM – 8:30 PM'], ['fa-solid fa-phone', '[Add business phone number]']],
                'Contact Store', 'contact'],
            ['fa-solid fa-screwdriver-wrench', 'emerald', 'Fast Repair', 'Repair & Service Center', '[Service center address coming soon.]', null,
                [['fa-regular fa-clock', 'Mon – Sat: 10:30 AM – 7:30 PM'], ['fa-solid fa-headset', 'Technician Support Available']],
                'Book Service', 'repair'],
            ['fa-solid fa-warehouse', 'purple', 'QA Hub', 'Online Hub & Warehouse', 'Direct dispatches across India with 24-hr QA.', null,
                [['fa-solid fa-truck-fast', 'Same-Day Dispatch Available'], ['fa-solid fa-shield-halved', '100% Insured Shipping']],
                'Browse Inventory', 'shop'],
            ['fa-solid fa-truck-fast', 'sky', 'Pan-India', 'Pan India Dispatch Hub', 'Express Courier Packing & Dispatch Unit.', null,
                [['fa-solid fa-box', '19,000+ Pincodes Covered'], ['fa-solid fa-shield-halved', 'Insured Transit Packaging']],
                'Track Dispatch', 'user.track-order'],
        ];

        foreach ($rows as $i => [$icon, $color, $badge, $title, $addr, $phone, $details, $btn, $link]) {
            DB::table('home_store_locations')->insert(array_merge([
                'icon' => $icon, 'color' => $color, 'badge' => $badge, 'title' => $title,
                'address' => $addr, 'phone' => $phone,
                'details' => $this->json(array_map(fn($d) => ['icon' => $d[0], 'text' => $d[1]], $details)),
                'button_text' => $btn, 'sort_order' => $i, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ], $this->link('button', $link)));
        }
    }
}