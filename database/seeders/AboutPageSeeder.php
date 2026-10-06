<?php
// database/seeders/AboutPageSeeder.php

namespace Database\Seeders;

use App\Models\AboutCommitment;
use App\Models\AboutPage;
use App\Models\AboutStat;
use App\Models\AboutTestGroup;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        if (!AboutPage::exists()) {
            AboutPage::create([
                'hero_badge'       => 'Our Mission',
                'hero_title'       => 'Technology That Fits Your Needs.',
                'hero_description' => '"Tested Technology. Trusted Value." At VANSH IT & COMM, we bridge the gap between premium electronics and accessible value through rigorous engineering, transparent condition grading, and reliable customer warranty support.',

                'who_badge'       => 'Who We Are',
                'who_title'       => 'Your Trusted Technology Partner',
                'who_description' => "Founded on the principle of giving high-end technology a smarter lifecycle, VANSH IT & COMM serves thousands of students, developers, remote professionals, and corporate teams across India.\n\nWe specialize in business-class laptops (Dell Latitude, Lenovo ThinkPad, HP EliteBook, Apple MacBook), certified smartphones, essential computer accessories, and expert hardware repair solutions.",
                'who_image'       => 'img/product-1588872657578-7efd1f1555ed.jpg',

                'testing_badge'       => 'Engineering Rigor',
                'testing_title'       => 'Our 20-Point Testing Approach',
                'testing_description' => 'Every laptop and smartphone undergoes rigorous multi-tier hardware diagnostics, thermal benchmarking, and quality grading before certification.',

                'banner_title'       => '100% Quality Assurance Certificate with Every Device',
                'banner_text'        => 'Each dispatched unit includes an individual technician sign-off sheet and serial-linked warranty.',
                'banner_button_text' => 'Shop Tested Tech',
                'banner_button_url'  => null, // falls back to the shop route
            ]);
        }

        if (!AboutStat::exists()) {
            AboutStat::insert([
                ['value' => '20+',  'label' => 'Diagnostic Checkpoints', 'color' => 'blue',    'sort_order' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['value' => '100%', 'label' => 'GST Invoice Compliant',  'color' => 'emerald', 'sort_order' => 2, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (!AboutTestGroup::exists()) {
            $groups = [
                [
                    'title' => 'Core Computing', 'subtitle' => 'Processor & Motherboard',
                    'icon' => 'fa-solid fa-microchip', 'color' => 'blue',
                    'footer_icon' => 'fa-solid fa-gauge-high', 'footer_label' => 'Peak Performance', 'footer_value' => 'Passed 100%',
                    'items' => [
                        'CPU & GPU Thermal Throttling Test',
                        'RAM MemTest86 Stress Verification',
                        'NVMe SSD SMART Health & Speeds',
                        'Motherboard VRM Voltage Stability',
                    ],
                ],
                [
                    'title' => 'Display & Optics', 'subtitle' => 'Screen & Visual Quality',
                    'icon' => 'fa-solid fa-display', 'color' => 'indigo',
                    'footer_icon' => 'fa-solid fa-eye', 'footer_label' => 'Grade A Clarity', 'footer_value' => 'Certified',
                    'items' => [
                        'Screen Pixel Defect & Bleed Audit',
                        'Color Gamut & Brightness Balance',
                        'Front / Rear Cameras & Autofocus',
                        'True Tone & Ambient Light Sensors',
                    ],
                ],
                [
                    'title' => 'Power & Ports', 'subtitle' => 'Battery & Connectivity',
                    'icon' => 'fa-solid fa-battery-half', 'color' => 'emerald',
                    'footer_icon' => 'fa-solid fa-bolt', 'footer_label' => 'Fast Charging', 'footer_value' => 'Verified',
                    'items' => [
                        '85%+ Certified Battery Capacity',
                        'Thunderbolt & Type-C Power Delivery',
                        'Wi-Fi 6 & Bluetooth Signal Strength',
                        'Microphones, Speakers & Audio Jacks',
                    ],
                ],
            ];

            foreach ($groups as $i => $g) {
                $items = $g['items'];
                unset($g['items']);

                $group = AboutTestGroup::create($g + ['sort_order' => $i + 1, 'status' => true]);

                foreach ($items as $n => $title) {
                    $group->items()->create(['title' => $title, 'sort_order' => $n + 1]);
                }
            }
        }

        if (!AboutCommitment::exists()) {
            AboutCommitment::insert([
                [
                    'icon' => 'fa-solid fa-hand-holding-heart', 'color' => 'blue',
                    'title' => 'No False Claims',
                    'description' => 'We provide transparent condition grading and clear warranty durations without confusing fine print.',
                    'sort_order' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'icon' => 'fa-solid fa-boxes-packing', 'color' => 'emerald',
                    'title' => 'Secure Packaging',
                    'description' => 'Multi-layer bubble wrapping and reinforced boxes ensure damage-free transit across India.',
                    'sort_order' => 2, 'status' => 1, 'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'icon' => 'fa-solid fa-headset', 'color' => 'purple',
                    'title' => 'Dedicated Support',
                    'description' => 'Our technical support team is available to assist you before and after your device purchase.',
                    'sort_order' => 3, 'status' => 1, 'created_at' => now(), 'updated_at' => now(),
                ],
            ]);
        }
    }
}