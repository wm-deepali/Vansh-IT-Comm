<?php

namespace Database\Seeders;

use App\Models\ExchangeBrandRule;
use App\Models\ExchangeOption;
use App\Models\ExchangePage;
use App\Models\ExchangeStep;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{
    public function run(): void
    {
        if (!ExchangePage::count()) {
            ExchangePage::create([
                'meta_title'         => 'Device Exchange & Upgrade Program | VANSH IT & COMM',
                'meta_description'   => 'Calculate your old laptop or smartphone trade-in value and upgrade to certified refurbished or new technology.',
                'hero_badge'         => 'SMART TRADE-IN',
                'hero_title'         => 'Your Old Device. Your Next Upgrade.',
                'hero_description'   => 'Trade in your pre-owned laptop or mobile phone to get instant store credit towards certified refurbished laptops or premium smartphones.',
                'steps_badge'        => 'How It Works',
                'steps_title'        => '5 Simple Steps to Upgrade',
                'calc_badge'         => 'Instant Valuation',
                'calc_title'         => 'Calculate Exchange Value',
                'calc_subtitle'      => 'Get an instant estimated trade-in price for your laptop or smartphone.',
                'calc_button_text'   => 'Get Estimated Exchange Value',
                'result_badge'       => 'ESTIMATED TRADE-IN VALUE',
                'result_text'        => 'Estimated value for your {brand} {model}. Final credit applied after physical testing.',
                'result_shop_text'   => 'Shop Laptops with Credit',
                'result_pickup_text' => 'Book Device Pickup',
            ]);
        }

        if (!ExchangeStep::count()) {
            $steps = [
                ['Tell Us About Device', 'Select brand, model, and physical condition.', 'blue'],
                ['Get Instant Value', 'Receive fair algorithmic estimated credit.', 'blue'],
                ['Device Inspection', 'Drop off at store or free doorstep pickup.', 'blue'],
                ['Exchange or Sell', 'Accept final valuation discount or cash.', 'blue'],
                ['Upgrade Tech', 'Take home your new high-performance device!', 'emerald'],
            ];
            foreach ($steps as $i => [$title, $desc, $color]) {
                ExchangeStep::create(['title' => $title, 'description' => $desc, 'color' => $color, 'sort_order' => $i + 1]);
            }
        }

        if (!ExchangeOption::count()) {
            $rows = [
                // type, label, value, base_min, base_max, min_mult, max_mult
                ['category', 'Laptop / Notebook', 'laptop', 8000, 14000, 1, 1],
                ['category', 'Mobile Phone / Smartphone', 'phone', 4000, 8000, 1, 1],
                ['category', 'Tablet / iPad', 'tablet', 4000, 8000, 1, 1],

                ['condition', 'Flawless / Excellent (No major scratches, 100% working)', 'excellent', null, null, 1.20, 1.25],
                ['condition', 'Good (Minor cosmetic scratches, fully working)', 'good', null, null, 1, 1],
                ['condition', 'Fair (Visible dents/marks, working battery)', 'average', null, null, 1, 1],
                ['condition', 'Faulty / Broken (Cracked screen or dead battery)', 'damaged', null, null, 0.40, 0.50],

                ['age', 'Less than 1 Year', '1', null, null, 1, 1],
                ['age', '1 to 2 Years', '2', null, null, 1, 1],
                ['age', '2 to 4 Years', '3', null, null, 1, 1],
                ['age', '4+ Years', '5', null, null, 1, 1],

                ['charger', 'Yes, Original Charger Included', 'yes', null, null, 1, 1],
                ['charger', 'No Charger', 'no', null, null, 1, 1],
            ];
            $order = [];
            foreach ($rows as [$type, $label, $value, $bmin, $bmax, $mmin, $mmax]) {
                $order[$type] = ($order[$type] ?? 0) + 1;
                ExchangeOption::create([
                    'type' => $type, 'label' => $label, 'value' => $value,
                    'base_min' => $bmin, 'base_max' => $bmax,
                    'min_multiplier' => $mmin, 'max_multiplier' => $mmax,
                    'sort_order' => $order[$type],
                ]);
            }
        }

        if (!ExchangeBrandRule::count()) {
            ExchangeBrandRule::create(['keyword' => 'apple',   'add_min' => 8000, 'add_max' => 12000, 'sort_order' => 1]);
            ExchangeBrandRule::create(['keyword' => 'dell',    'add_min' => 3000, 'add_max' => 5000,  'sort_order' => 2]);
            ExchangeBrandRule::create(['keyword' => 'samsung', 'add_min' => 3000, 'add_max' => 5000,  'sort_order' => 3]);
        }
    }
}