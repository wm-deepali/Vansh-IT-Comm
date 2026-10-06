<?php
// app/Http/Controllers/Admin/RepairPageController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairCategory;
use App\Models\RepairOption;
use App\Models\RepairPage;
use App\Models\RepairService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RepairPageController extends Controller
{
    private const ICON_RULE = 'regex:/^[a-z0-9\- ]+$/i';

    public function edit()
    {
        $page       = RepairPage::first() ?? new RepairPage;
        $categories = RepairCategory::with('services')->orderBy('sort_order')->orderBy('id')->get();
        $options    = RepairOption::orderBy('sort_order')->orderBy('id')->get()->groupBy('type');
        $colors     = RepairService::COLORS;

        return view('admin.repair-page.edit', compact('page', 'categories', 'options', 'colors'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:500',

            'hero_badge'          => 'nullable|string|max:255',
            'hero_title'          => 'nullable|string|max:255',
            'hero_description'    => 'nullable|string|max:2000',
            'hero_primary_text'   => 'nullable|string|max:100',
            'hero_secondary_text' => 'nullable|string|max:100',

            'booking_badge'       => 'nullable|string|max:255',
            'booking_title'       => 'nullable|string|max:255',
            'booking_description' => 'nullable|string|max:1000',
            'booking_note'        => 'nullable|string|max:500',

            'categories.*.eyebrow' => 'nullable|string|max:255',
            'categories.*.title'   => 'required|string|max:255',

            'categories.*.services.*.title'          => 'required|string|max:255',
            'categories.*.services.*.description'    => 'nullable|string|max:1000',
            'categories.*.services.*.estimated_time' => 'nullable|string|max:100',
            'categories.*.services.*.icon'           => ['nullable', 'string', 'max:100', self::ICON_RULE],
            'categories.*.services.*.color'          => ['required', Rule::in(RepairService::COLORS)],

            'options.*'           => 'nullable|string|max:3000',
        ]);

        DB::transaction(function () use ($request) {

            /* ── Page texts ── */
            $page = RepairPage::first() ?? new RepairPage;
            $page->fill($request->only([
                'meta_title', 'meta_description',
                'hero_badge', 'hero_title', 'hero_description', 'hero_primary_text', 'hero_secondary_text',
                'booking_badge', 'booking_title', 'booking_description', 'booking_note',
            ]))->save();

            /* ── Categories + services (saved in on-screen order) ── */
            RepairService::query()->delete();
            RepairCategory::query()->delete();

            foreach (array_values($request->input('categories', [])) as $i => $row) {
                $category = RepairCategory::create([
                    'eyebrow'    => $row['eyebrow'] ?? null,
                    'title'      => $row['title'],
                    'sort_order' => $i + 1,
                    'status'     => !empty($row['status']),
                ]);

                foreach (array_values($row['services'] ?? []) as $j => $svc) {
                    $category->services()->create([
                        'title'          => $svc['title'],
                        'description'    => $svc['description'] ?? null,
                        'estimated_time' => $svc['estimated_time'] ?? null,
                        'icon'           => ($svc['icon'] ?? null) ?: 'fa-solid fa-screwdriver-wrench',
                        'color'          => $svc['color'],
                        'sort_order'     => $j + 1,
                        'status'         => !empty($svc['status']),
                    ]);
                }
            }

            /* ── Dropdown options: one line each, "Label | stored value" ── */
            RepairOption::query()->delete();

            foreach (array_keys(RepairOption::TYPES) as $type) {
                $n = 0;
                foreach (preg_split('/\R/', (string) $request->input("options.$type", '')) as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        continue;
                    }

                    [$label, $value] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null);

                    RepairOption::create([
                        'type'       => $type,
                        'label'      => mb_substr($label, 0, 255),
                        'value'      => mb_substr($value ?: $label, 0, 255),
                        'sort_order' => ++$n,
                        'status'     => true,
                    ]);
                }
            }
        });

        return redirect()->route('admin.repair-page.edit')
            ->with('success', 'Repair page updated successfully.');
    }
}