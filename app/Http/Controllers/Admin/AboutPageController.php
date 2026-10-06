<?php
// app/Http/Controllers/Admin/AboutPageController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCommitment;
use App\Models\AboutPage;
use App\Models\AboutStat;
use App\Models\AboutTestGroup;
use App\Models\AboutTestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AboutPageController extends Controller
{
    private const COLORS    = ['blue', 'indigo', 'emerald', 'purple', 'amber', 'rose'];
    private const ICON_RULE = 'regex:/^[a-z0-9\- ]+$/i';

    /*
    |--------------------------------------------------
    | EDIT
    |--------------------------------------------------
    */
    public function edit()
    {
        $about       = AboutPage::first() ?? new AboutPage;
        $stats       = AboutStat::orderBy('sort_order')->orderBy('id')->get();
        $groups      = AboutTestGroup::with('items')->orderBy('sort_order')->orderBy('id')->get();
        $commitments = AboutCommitment::orderBy('sort_order')->orderBy('id')->get();
        $colors      = self::COLORS;

        return view('admin.about-page.edit', compact('about', 'stats', 'groups', 'commitments', 'colors'));
    }

    /*
    |--------------------------------------------------
    | UPDATE (page texts + all repeaters in one go)
    |--------------------------------------------------
    */
    public function update(Request $request)
    {
        $request->validate([
            'hero_badge'          => 'nullable|string|max:255',
            'hero_title'          => 'nullable|string|max:255',
            'hero_description'    => 'nullable|string|max:2000',

            'who_badge'           => 'nullable|string|max:255',
            'who_title'           => 'nullable|string|max:255',
            'who_description'     => 'nullable|string|max:5000',
            'who_image'           => 'nullable|image|max:4096',

            'testing_badge'       => 'nullable|string|max:255',
            'testing_title'       => 'nullable|string|max:255',
            'testing_description' => 'nullable|string|max:2000',

            'banner_title'        => 'nullable|string|max:255',
            'banner_text'         => 'nullable|string|max:1000',
            'banner_button_text'  => 'nullable|string|max:100',
            'banner_button_url'   => 'nullable|string|max:255',

            'stats.*.value'       => 'required|string|max:50',
            'stats.*.label'       => 'required|string|max:255',
            'stats.*.color'       => ['required', Rule::in(self::COLORS)],

            'groups.*.title'        => 'required|string|max:255',
            'groups.*.subtitle'     => 'nullable|string|max:255',
            'groups.*.icon'         => ['nullable', 'string', 'max:100', self::ICON_RULE],
            'groups.*.color'        => ['required', Rule::in(self::COLORS)],
            'groups.*.footer_icon'  => ['nullable', 'string', 'max:100', self::ICON_RULE],
            'groups.*.footer_label' => 'nullable|string|max:255',
            'groups.*.footer_value' => 'nullable|string|max:255',
            'groups.*.items'        => 'nullable|string|max:3000',

            'commitments.*.title'       => 'required|string|max:255',
            'commitments.*.description' => 'nullable|string|max:1000',
            'commitments.*.icon'        => ['nullable', 'string', 'max:100', self::ICON_RULE],
            'commitments.*.color'       => ['required', Rule::in(self::COLORS)],
        ]);

        DB::transaction(function () use ($request) {

            /* ── Page texts + image ── */
            $about = AboutPage::first() ?? new AboutPage;

            $data = $request->only([
                'hero_badge', 'hero_title', 'hero_description',
                'who_badge', 'who_title', 'who_description',
                'testing_badge', 'testing_title', 'testing_description',
                'banner_title', 'banner_text', 'banner_button_text', 'banner_button_url',
            ]);

            if ($request->boolean('remove_who_image')) {
                $this->deleteImage($about->who_image);
                $data['who_image'] = null;
            }

            if ($request->hasFile('who_image')) {
                $this->deleteImage($about->who_image);
                $data['who_image'] = $request->file('who_image')->store('about', 'public');
            }

            $about->fill($data)->save();

            /* ── Stats (rows are saved in the order they appear on screen) ── */
            AboutStat::query()->delete();
            $i = 0;
            foreach ($request->input('stats', []) as $row) {
                AboutStat::create([
                    'value'      => $row['value'],
                    'label'      => $row['label'],
                    'color'      => $row['color'],
                    'sort_order' => ++$i,
                    'status'     => !empty($row['status']),
                ]);
            }

            /* ── Test groups + items ── */
            AboutTestItem::query()->delete();
            AboutTestGroup::query()->delete();
            $i = 0;
            foreach ($request->input('groups', []) as $row) {
                $group = AboutTestGroup::create([
                    'title'        => $row['title'],
                    'subtitle'     => $row['subtitle'] ?? null,
                    'icon'         => ($row['icon'] ?? null) ?: 'fa-solid fa-microchip',
                    'color'        => $row['color'],
                    'footer_icon'  => $row['footer_icon'] ?? null,
                    'footer_label' => $row['footer_label'] ?? null,
                    'footer_value' => $row['footer_value'] ?? null,
                    'sort_order'   => ++$i,
                    'status'       => !empty($row['status']),
                ]);

                $lines = preg_split('/\R/', $row['items'] ?? '');
                $n = 0;
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        continue;
                    }
                    $group->items()->create(['title' => $line, 'sort_order' => ++$n]);
                }
            }

            /* ── Commitments ── */
            AboutCommitment::query()->delete();
            $i = 0;
            foreach ($request->input('commitments', []) as $row) {
                AboutCommitment::create([
                    'title'       => $row['title'],
                    'description' => $row['description'] ?? null,
                    'icon'        => ($row['icon'] ?? null) ?: 'fa-solid fa-shield-halved',
                    'color'       => $row['color'],
                    'sort_order'  => ++$i,
                    'status'      => !empty($row['status']),
                ]);
            }
        });

        return redirect()->route('admin.about-page.edit')
            ->with('success', 'About page updated successfully.');
    }

    /*
    |--------------------------------------------------
    | Delete only files uploaded to storage (seeded files in /public are untouched)
    |--------------------------------------------------
    */
    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}