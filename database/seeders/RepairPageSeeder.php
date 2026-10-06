<?php
// database/seeders/RepairPageSeeder.php

namespace Database\Seeders;

use App\Models\RepairCategory;
use App\Models\RepairOption;
use App\Models\RepairPage;
use Illuminate\Database\Seeder;

class RepairPageSeeder extends Seeder
{
    public function run(): void
    {
        if (!RepairPage::exists()) {
            RepairPage::create([
                'meta_title'       => 'Professional Laptop & Mobile Repair Services | VANSH IT & COMM',
                'meta_description' => 'Expert screen replacement, battery replacement, SSD/RAM upgrades, and motherboard repairs with genuine components and transparent pricing.',

                'hero_badge'          => 'Certified Technicians',
                'hero_title'          => 'Professional Laptop & Mobile Repair Services',
                'hero_description'    => 'Fast, reliable, and transparent repair solutions for all major laptop and smartphone brands. Screen replacement, battery upgrades, hardware servicing, and chip-level motherboard diagnostics.',
                'hero_primary_text'   => 'Book Repair',
                'hero_secondary_text' => 'Call Expert',

                'booking_badge'       => 'Fast Service Request',
                'booking_title'       => 'Book a Repair Service',
                'booking_description' => 'Fill in your device details and our technician will contact you with diagnostic estimates.',
                'booking_note'        => 'No upfront payment required. You will receive an estimate before any work begins.',
            ]);
        }

        if (!RepairCategory::exists()) {
            $categories = [
                [
                    'eyebrow' => 'Hardware & Software Fixes',
                    'title'   => 'Laptop Repair Services',
                    'services' => [
                        ['Screen Replacement', 'FHD, IPS, OLED & Touch screens replaced for Dell, HP, Lenovo, Asus, and MacBooks.', '2–4 Hours', 'fa-solid fa-display', 'blue'],
                        ['Battery Replacement', 'Original grade replacement batteries with verified capacity and backup guarantee.', '30 Mins', 'fa-solid fa-battery-three-quarters', 'emerald'],
                        ['SSD & RAM Speed Upgrade', 'NVMe SSD upgrades with complete OS cloning and RAM expansion to speed up slow machines.', '45 Mins', 'fa-solid fa-hard-drive', 'purple'],
                        ['Keyboard & Trackpad', 'Fix sticky keys, liquid spill damage, non-working keys, and erratic cursor issues.', '2 Hours', 'fa-solid fa-keyboard', 'amber'],
                        ['Thermal Cleaning & Fan Service', 'Deep dust cleanup, Arctic MX-4 thermal paste re-application, and overheat resolution.', '1 Hour', 'fa-solid fa-fan', 'rose'],
                        ['Motherboard Chip-Level Repair', 'Short-circuit diagnostic, power IC replacement, charging port repair, and BIOS reprogramming.', '24–48 Hours', 'fa-solid fa-microchip', 'indigo'],
                    ],
                ],
                [
                    'eyebrow' => 'Smartphones & Tablets',
                    'title'   => 'Mobile Repair Services',
                    'services' => [
                        ['Mobile Screen & OLED Replacement', 'High-refresh rate 120Hz OLED and LCD assemblies for iPhone, Samsung, OnePlus & Pixel.', '1 Hour', 'fa-solid fa-mobile-screen', 'blue'],
                        ['Phone Battery Replacement', 'Restore 100% battery health with genuine high-density Li-Po batteries.', '30 Mins', 'fa-solid fa-battery-full', 'emerald'],
                        ['Charging Port & Jack Fix', 'Fix loose Type-C or Lightning connectors, slow charging, and data transfer faults.', '45 Mins', 'fa-solid fa-plug', 'amber'],
                        ['Camera & Glass Repair', 'Blurry camera lens, cracked camera glass, and OIS sensor calibration.', '1 Hour', 'fa-solid fa-camera', 'purple'],
                        ['Speaker & Mic Restoration', 'Fix low ear-speaker volume, distorted loud-speakers, and call microphone issues.', '45 Mins', 'fa-solid fa-volume-high', 'sky'],
                        ['Back Glass & Housing', 'Laser back glass removal and full chassis replacement for pristine condition.', '2 Hours', 'fa-solid fa-shield', 'slate'],
                    ],
                ],
            ];

            foreach ($categories as $i => $cat) {
                $category = RepairCategory::create([
                    'eyebrow'    => $cat['eyebrow'],
                    'title'      => $cat['title'],
                    'sort_order' => $i + 1,
                    'status'     => true,
                ]);

                foreach ($cat['services'] as $j => [$title, $description, $time, $icon, $color]) {
                    $category->services()->create([
                        'title'          => $title,
                        'description'    => $description,
                        'estimated_time' => $time,
                        'icon'           => $icon,
                        'color'          => $color,
                        'sort_order'     => $j + 1,
                        'status'         => true,
                    ]);
                }
            }
        }

        if (!RepairOption::exists()) {
            $options = [
                'device_type' => [
                    ['Laptop', 'Laptop'],
                    ['Mobile Phone', 'Mobile Phone'],
                    ['Desktop PC', 'Desktop PC'],
                    ['Tablet / iPad', 'Tablet'],
                ],
                'issue' => [
                    ['Screen Cracked / Blank Display', 'Screen Replacement'],
                    ['Battery Draining Fast / Not Charging', 'Battery Health'],
                    ['Slow Performance / SSD & RAM Upgrade', 'Slow Performance / SSD Upgrade'],
                    ['Keyboard / Trackpad Not Responding', 'Keyboard / Trackpad'],
                    ['Device Not Turning On (Motherboard)', 'Motherboard Fault'],
                    ['Overheating / Fan Noise', 'Overheating'],
                    ['Liquid Spill / Water Damage', 'Liquid Spill'],
                    ['Other Problem (Describe below)', 'Other'],
                ],
                'service_mode' => [
                    ['Drop-off at Store', 'Store Drop-off'],
                    ['Doorstep Courier Pickup', 'Courier Pickup'],
                ],
            ];

            foreach ($options as $type => $rows) {
                foreach ($rows as $n => [$label, $value]) {
                    RepairOption::create([
                        'type'       => $type,
                        'label'      => $label,
                        'value'      => $value,
                        'sort_order' => $n + 1,
                        'status'     => true,
                    ]);
                }
            }
        }
    }
}