<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeBrandRule;
use App\Models\ExchangeOption;
use App\Models\ExchangePage;
use App\Models\ExchangeRequest;
use App\Models\ExchangeStep;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExchangeAdminController extends Controller
{
    private array $colors = ['blue', 'emerald', 'indigo', 'amber', 'rose', 'purple', 'teal', 'slate'];

    public function edit()
    {
        return view('admin.exchange.edit', [
            'page'    => ExchangePage::content(),
            'steps'   => ExchangeStep::orderBy('sort_order')->orderBy('id')->get(),
            'options' => ExchangeOption::orderBy('sort_order')->orderBy('id')->get()->groupBy('type'),
            'brands'  => ExchangeBrandRule::orderBy('sort_order')->orderBy('id')->get(),
            'colors'  => $this->colors,
        ]);
    }

    public function update(Request $request)
    {
        $pageFields = [
            'meta_title', 'meta_description', 'hero_badge', 'hero_title', 'hero_description',
            'steps_badge', 'steps_title', 'calc_badge', 'calc_title', 'calc_subtitle',
            'calc_button_text', 'result_badge', 'result_text', 'result_shop_text', 'result_pickup_text',
        ];

        $data = $request->validate([
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'hero_badge'         => 'nullable|string|max:255',
            'hero_title'         => 'nullable|string|max:255',
            'hero_description'   => 'nullable|string',
            'steps_badge'        => 'nullable|string|max:255',
            'steps_title'        => 'nullable|string|max:255',
            'calc_badge'         => 'nullable|string|max:255',
            'calc_title'         => 'nullable|string|max:255',
            'calc_subtitle'      => 'nullable|string',
            'calc_button_text'   => 'nullable|string|max:255',
            'result_badge'       => 'nullable|string|max:255',
            'result_text'        => 'nullable|string',
            'result_shop_text'   => 'nullable|string|max:255',
            'result_pickup_text' => 'nullable|string|max:255',

            'steps'                 => 'nullable|array',
            'steps.*.title'         => 'required|string|max:150',
            'steps.*.description'   => 'nullable|string',
            'steps.*.color'         => 'required|string|max:30',
            'steps.*.status'        => 'nullable|boolean',

            'categories'                => 'required|array|min:1',
            'categories.*.label'        => 'required|string|max:255',
            'categories.*.value'        => 'nullable|string|max:50|distinct',
            'categories.*.base_min'     => 'required|integer|min:0',
            'categories.*.base_max'     => 'required|integer|min:0|gte:categories.*.base_min',
            'categories.*.status'       => 'nullable|boolean',

            'conditions'                    => 'required|array|min:1',
            'conditions.*.label'            => 'required|string|max:255',
            'conditions.*.value'            => 'nullable|string|max:50|distinct',
            'conditions.*.min_multiplier'   => 'required|numeric|min:0|max:10',
            'conditions.*.max_multiplier'   => 'required|numeric|min:0|max:10',
            'conditions.*.status'           => 'nullable|boolean',

            'brands'                => 'nullable|array',
            'brands.*.keyword'      => 'required|string|max:100',
            'brands.*.add_min'      => 'nullable|integer|min:0',
            'brands.*.add_max'      => 'nullable|integer|min:0',
            'brands.*.status'       => 'nullable|boolean',

            'options'               => 'nullable|array',
            'options.*'             => 'nullable|string',
        ]);

        DB::transaction(function () use ($data, $pageFields) {
            ExchangePage::content()->update(Arr::only($data, $pageFields));

            // ---- Steps ----
            ExchangeStep::query()->delete();
            foreach (array_values($data['steps'] ?? []) as $i => $s) {
                ExchangeStep::create([
                    'title'       => $s['title'],
                    'description' => $s['description'] ?? null,
                    'color'       => $s['color'],
                    'sort_order'  => $i + 1,
                    'status'      => (int) ($s['status'] ?? 0),
                ]);
            }

            // ---- Options (rebuilt every save) ----
            ExchangeOption::query()->delete();

            foreach (array_values($data['categories']) as $i => $c) {
                ExchangeOption::create([
                    'type'       => 'category',
                    'label'      => $c['label'],
                    'value'      => $c['value'] ?: Str::slug($c['label'], '_'),
                    'base_min'   => $c['base_min'],
                    'base_max'   => $c['base_max'],
                    'sort_order' => $i + 1,
                    'status'     => (int) ($c['status'] ?? 0),
                ]);
            }

            foreach (array_values($data['conditions']) as $i => $c) {
                ExchangeOption::create([
                    'type'           => 'condition',
                    'label'          => $c['label'],
                    'value'          => $c['value'] ?: Str::slug($c['label'], '_'),
                    'min_multiplier' => $c['min_multiplier'],
                    'max_multiplier' => $c['max_multiplier'],
                    'sort_order'     => $i + 1,
                    'status'         => (int) ($c['status'] ?? 0),
                ]);
            }

            // age / charger: one "Label | value" per line
            foreach (array_keys(ExchangeOption::TYPES) as $type) {
                $lines = preg_split('/\r\n|\r|\n/', (string) ($data['options'][$type] ?? ''));
                $order = 0;
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        continue;
                    }
                    [$label, $value] = array_pad(array_map('trim', explode('|', $line, 2)), 2, null);
                    ExchangeOption::create([
                        'type'       => $type,
                        'label'      => $label,
                        'value'      => $value !== null && $value !== '' ? $value : $label,
                        'sort_order' => ++$order,
                        'status'     => 1,
                    ]);
                }
            }

            // ---- Brand rules ----
            ExchangeBrandRule::query()->delete();
            foreach (array_values($data['brands'] ?? []) as $i => $b) {
                ExchangeBrandRule::create([
                    'keyword'    => $b['keyword'],
                    'add_min'    => (int) ($b['add_min'] ?? 0),
                    'add_max'    => (int) ($b['add_max'] ?? 0),
                    'sort_order' => $i + 1,
                    'status'     => (int) ($b['status'] ?? 0),
                ]);
            }
        });

        return redirect()->route('admin.exchange-page.edit')->with('success', 'Exchange page updated successfully.');
    }

    // ---- Submitted valuations ----

    public function requests()
    {
        $requests = ExchangeRequest::latest()->paginate(20);
        return view('admin.exchange.requests', compact('requests'));
    }

    public function requestStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:new,contacted,completed,cancelled']);
        ExchangeRequest::findOrFail($id)->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status updated.']);
    }

    public function requestDestroy(int $id)
    {
        ExchangeRequest::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
}