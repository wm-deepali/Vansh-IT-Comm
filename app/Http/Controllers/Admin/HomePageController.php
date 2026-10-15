<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBudgetCard;
use App\Models\HomeCtaBlock;
use App\Models\HomeFeature;
use App\Models\HomeGuidedOption;
use App\Models\HomeHeroSlide;
use App\Models\HomeProcessStep;
use App\Models\HomeSectionHeading;
use App\Models\HomeStoreLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    public const COLORS = [
        'blue', 'emerald', 'purple', 'amber', 'rose',
        'indigo', 'sky', 'teal', 'pink', 'orange', 'slate',
    ];

    /** key => label shown in admin */
    public const HEADINGS = [
        'categories'      => 'Shop By Category',
        'featured_1'      => 'Featured Section #1 (1st popular category)',
        'budget'          => 'Shop Laptops By Budget',
        'featured_2'      => 'Featured Section #2 (2nd popular category)',
        'guided'          => 'Guided Recommendation ("What\'s Right For You?")',
        'featured_3'      => 'Featured Section #3 (Accessories)',
        'brands'          => 'Shop By Brand',
        'refurbish'       => 'How We Refurbish',
        'why_us'          => 'Why Choose Us',
        'store_locations' => 'Store Locations & Hubs',
        'faq'             => 'FAQ',
    ];

    /** key => label shown in admin */
    public const CTA_BLOCKS = [
        'brand_philosophy' => 'Brand Philosophy ("The Smarter Way To Buy Tech")',
        'repair_cta'       => 'Repair CTA',
        'exchange_cta'     => 'Device Exchange CTA',
        'final_cta'        => 'Final CTA ("Ready To Upgrade?")',
    ];

    public function edit()
    {
        return view('admin.home-page.edit', [
            'headings'     => HomeSectionHeading::allKeyed(),
            'slides'       => HomeHeroSlide::ordered()->get(),
            'trustItems'   => HomeFeature::section(HomeFeature::SECTION_TRUST)->ordered()->get(),
            'whyItems'     => HomeFeature::section(HomeFeature::SECTION_WHY)->ordered()->get(),
            'budgetCards'  => HomeBudgetCard::ordered()->get(),
            'guided'       => HomeGuidedOption::ordered()->get(),
            'steps'        => HomeProcessStep::ordered()->get(),
            'ctaBlocks'    => HomeCtaBlock::allKeyed(),
            'stores'       => HomeStoreLocation::ordered()->get(),
            'colors'       => self::COLORS,
            'headingKeys'  => self::HEADINGS,
            'ctaKeys'      => self::CTA_BLOCKS,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'slides.*.card_image_file' => 'nullable|image|max:3072',
            'budget.*.min_price'       => 'nullable|integer|min:0',
            'budget.*.max_price'       => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $this->saveHeadings($request);
            $this->saveSlides($request);
            $this->saveFeatures($request, 'trust', HomeFeature::SECTION_TRUST);
            $this->saveFeatures($request, 'why', HomeFeature::SECTION_WHY);
            $this->saveBudgetCards($request);
            $this->saveGuided($request);
            $this->saveSteps($request);
            $this->saveCtaBlocks($request);
            $this->saveStores($request);
        });

        return redirect()->route('admin.home-page.index')->with('success', 'Home page updated successfully.');
    }

    /* ───────────────────────── savers ───────────────────────── */

    private function saveHeadings(Request $request): void
    {
        foreach (array_keys(self::HEADINGS) as $key) {
            $row = $request->input("headings.$key");
            if (!is_array($row)) {
                continue;
            }

            $row = $this->withLinks($row, ['link']);
            $row['is_active'] = isset($row['is_active']);

            HomeSectionHeading::updateOrCreate(
                ['key' => $key],
                Arr::only($row, (new HomeSectionHeading)->getFillable())
            );
        }
    }

    private function saveSlides(Request $request): void
    {
        HomeHeroSlide::query()->delete();

        $sort = 0;
        foreach ($this->rows($request, 'slides', 'title_line_1') as $k => $row) {
            $row = $this->withLinks($row, ['btn_primary', 'btn_secondary', 'link']);
            $row['trust_points'] = $this->parsePipes($row['trust_points'] ?? '', ['icon', 'color', 'text']);
            $row['is_active']    = isset($row['is_active']);
            $row['sort_order']   = $sort++;

            $file = $request->file("slides.$k.card_image_file");
            if ($file && $file->isValid()) {
                $name = Str::random(24) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/home'), $name);
                $row['card_image'] = 'uploads/home/' . $name;
            }

            HomeHeroSlide::create(Arr::only($row, (new HomeHeroSlide)->getFillable()));
        }
    }

    private function saveFeatures(Request $request, string $inputKey, string $section): void
    {
        HomeFeature::where('section', $section)->delete();

        $sort = 0;
        foreach ($this->rows($request, $inputKey, 'title') as $row) {
            $row['section']    = $section;
            $row['is_active']  = isset($row['is_active']);
            $row['sort_order'] = $sort++;

            HomeFeature::create(Arr::only($row, (new HomeFeature)->getFillable()));
        }
    }

    private function saveBudgetCards(Request $request): void
    {
        HomeBudgetCard::query()->delete();

        $sort = 0;
        foreach ($this->rows($request, 'budget', 'title') as $row) {
            $row['is_active']  = isset($row['is_active']);
            $row['sort_order'] = $sort++;

            HomeBudgetCard::create(Arr::only($row, (new HomeBudgetCard)->getFillable()));
        }
    }

    private function saveGuided(Request $request): void
    {
        HomeGuidedOption::query()->delete();

        $sort = 0;
        foreach ($this->rows($request, 'guided', 'title') as $row) {
            $row = $this->withLinks($row, ['button']);
            $row['features']   = $this->lines($row['features'] ?? '');
            $row['is_active']  = isset($row['is_active']);
            $row['sort_order'] = $sort++;

            HomeGuidedOption::create(Arr::only($row, (new HomeGuidedOption)->getFillable()));
        }
    }

    private function saveSteps(Request $request): void
    {
        HomeProcessStep::query()->delete();

        $sort = 0;
        foreach ($this->rows($request, 'steps', 'title') as $row) {
            $row['is_active']  = isset($row['is_active']);
            $row['sort_order'] = $sort++;

            HomeProcessStep::create(Arr::only($row, (new HomeProcessStep)->getFillable()));
        }
    }

    private function saveCtaBlocks(Request $request): void
    {
        foreach (self::CTA_BLOCKS as $key => $label) {
            $row = $request->input("cta.$key");
            if (!is_array($row)) {
                continue;
            }

            $row = $this->withLinks($row, ['btn_1', 'btn_2', 'btn_3']);
            $row['title']     = filled($row['title'] ?? null) ? $row['title'] : $label;
            $row['items']     = $this->parsePipes($row['items'] ?? '', ['icon', 'color', 'text', 'tag']);
            $row['is_active'] = isset($row['is_active']);

            HomeCtaBlock::updateOrCreate(
                ['key' => $key],
                Arr::only($row, (new HomeCtaBlock)->getFillable())
            );
        }
    }

    private function saveStores(Request $request): void
    {
        HomeStoreLocation::query()->delete();

        $sort = 0;
        foreach ($this->rows($request, 'stores', 'title') as $row) {
            $row = $this->withLinks($row, ['button']);
            $row['details']    = $this->parsePipes($row['details'] ?? '', ['icon', 'text']);
            $row['is_active']  = isset($row['is_active']);
            $row['sort_order'] = $sort++;

            HomeStoreLocation::create(Arr::only($row, (new HomeStoreLocation)->getFillable()));
        }
    }

    /* ───────────────────────── helpers ───────────────────────── */

    /** Submitted repeater rows (original keys kept) that have a non-empty $required field. */
    private function rows(Request $request, string $key, string $required): array
    {
        return collect($request->input($key, []))
            ->filter(fn($row) => is_array($row) && filled($row[$required] ?? null))
            ->all();
    }

    /** One trimmed, non-empty line per array item. */
    private function lines(?string $text): array
    {
        return array_values(array_filter(
            array_map('trim', preg_split('/\R/', (string) $text)),
            fn($l) => $l !== ''
        ));
    }

    /** "a | b | c" lines => [['k1'=>'a','k2'=>'b','k3'=>'c'], ...] (last key keeps any extra pipes). */
    private function parsePipes(?string $text, array $keys): array
    {
        return array_map(function ($line) use ($keys) {
            $parts = array_map('trim', explode('|', $line, count($keys)));
            $out = [];
            foreach ($keys as $i => $k) {
                $out[$k] = $parts[$i] ?? '';
            }
            return $out;
        }, $this->lines($text));
    }

    /** Splits each "<prefix>_link" input into <prefix>_route (if it is a named route) or <prefix>_url. */
    private function withLinks(array $row, array $prefixes): array
    {
        foreach ($prefixes as $p) {
            $v = trim((string) ($row[$p . '_link'] ?? ''));

            $row[$p . '_route'] = ($v !== '' && Route::has($v)) ? $v : null;
            $row[$p . '_url']   = ($v !== '' && !Route::has($v)) ? $v : null;

            unset($row[$p . '_link']);
        }

        return $row;
    }
}