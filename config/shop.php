<?php

// config/shop.php — store-wide settings used by the Blade views (no literals in templates)

return [
    'currency'          => '₹',
    'phone_code'        => '+91',
    'default_spec_icon' => 'fa-solid fa-circle-check',

    // Label shown for products flagged "quality" (QC-certified)
    'qc_label'          => '20-Point QC',

    // Product page price block. Set emi_months to null/0 to hide the EMI line.
    'tax_note'          => 'Inclusive of all taxes + 100% GST Input Invoice.',

    // Spec tiles on the product page cycle through these colours
    'tile_palette'      => [
        'bg-blue-50 text-blue-600',
        'bg-purple-50 text-purple-600',
        'bg-emerald-50 text-emerald-600',
        'bg-indigo-50 text-indigo-600',
        'bg-amber-50 text-amber-600',
        'bg-sky-50 text-sky-600',
    ],

    // Live video-call inspection form options
    'video_call' => [
        'platforms' => ['WhatsApp Video', 'Google Meet', 'Zoom'],
        'slots'     => [
            'Instant (Within 15 Mins)',
            'Morning (10 AM - 1 PM)',
            'Afternoon (1 PM - 5 PM)',
            'Evening (5 PM - 8 PM)',
        ],
        'checks'    => [
            'Physical Body & Scratch Check',
            'Screen Quality & Dead Pixel Test',
            'Battery Health Cycle & Backup',
            'Original Charger & Serial Number',
        ],
    ],
];