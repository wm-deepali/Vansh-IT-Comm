@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --sp-bg: #f1f2f4;
            --sp-surface: #ffffff;
            --sp-border: #e3e5e8;
            --sp-border-hover: #c9cccf;
            --sp-text-primary: #202223;
            --sp-text-secondary: #6d7175;
            --sp-text-hint: #8c9196;
            --sp-accent: #303d89;
            --sp-accent-hover: #2a3579;
            --sp-accent-light: #eef0fc;
            --sp-red: #c0392b;
            --sp-red-bg: #fce8e8;
            --sp-green: #007a5e;
            --sp-green-bg: #e3f1ec;
            --sp-radius-sm: 6px;
            --sp-radius-md: 8px;
            --sp-radius-lg: 12px;
            --sp-shadow-card: 0 1px 0 rgba(0, 0, 0, .05), 0 0 0 1px rgba(0, 0, 0, .07);
            --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .sp-page {
            background: var(--sp-bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--sp-font);
            color: var(--sp-text-primary);
            font-size: 14px;
        }

        .sp-page * {
            box-sizing: border-box;
        }

        .sp-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .sp-page-title {
            font-size: 20px;
            font-weight: 660;
            margin: 0 0 4px;
            letter-spacing: -.2px;
        }

        .sp-crumb {
            font-size: 12.5px;
            color: var(--sp-text-hint);
            display: flex;
            align-items: center;
            gap: 4px;
            flex-wrap: wrap;
        }

        .sp-crumb a {
            color: var(--sp-accent);
            text-decoration: none;
        }

        .sp-crumb a:hover {
            text-decoration: underline;
        }

        .sp-card {
            background: var(--sp-surface);
            border-radius: var(--sp-radius-lg);
            box-shadow: var(--sp-shadow-card);
            border: 1px solid var(--sp-border);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .sp-card-header {
            padding: 13px 20px;
            border-bottom: 1px solid var(--sp-border);
            background: #fafafa;
        }

        .sp-card-header h5 {
            font-size: 13px;
            font-weight: 650;
            margin: 0;
        }

        .sp-card-header p {
            font-size: 11.5px;
            color: var(--sp-text-hint);
            margin: 2px 0 0;
        }

        .sp-card-body {
            padding: 20px 24px;
        }

        .sp-field {
            margin-bottom: 18px;
        }

        .sp-field:last-child {
            margin-bottom: 0;
        }

        .sp-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .sp-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 700px) {

            .sp-row,
            .sp-row-3 {
                grid-template-columns: 1fr;
            }
        }

        .sp-label {
            display: block;
            font-size: 12px;
            font-weight: 620;
            color: var(--sp-text-secondary);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .sp-req {
            color: var(--sp-red);
            margin-left: 2px;
        }

        .sp-hint {
            font-size: 11.5px;
            color: var(--sp-text-hint);
            margin-top: 5px;
        }

        .sp-input,
        .sp-textarea,
        .sp-select {
            width: 100%;
            border: 1px solid var(--sp-border);
            border-radius: var(--sp-radius-md);
            padding: 0 12px;
            font-size: 13.5px;
            color: var(--sp-text-primary);
            background: var(--sp-surface);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            font-family: var(--sp-font);
        }

        .sp-input,
        .sp-select {
            height: 38px;
        }

        .sp-textarea {
            padding: 10px 12px;
            resize: vertical;
            min-height: 80px;
            line-height: 1.6;
        }

        .sp-input:focus,
        .sp-textarea:focus,
        .sp-select:focus {
            border-color: var(--sp-accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .10);
        }

        .sp-item {
            border: 1px solid var(--sp-border);
            border-radius: var(--sp-radius-md);
            margin-bottom: 12px;
            background: var(--sp-surface);
            overflow: hidden;
        }

        .sp-item-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 8px 14px;
            background: #fafafa;
            border-bottom: 1px solid var(--sp-border);
        }

        .sp-item-title {
            font-size: 12.5px;
            font-weight: 650;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sp-item-no {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--sp-accent-light);
            color: var(--sp-accent);
            font-size: 11px;
            font-weight: 700;
        }

        .sp-item-tools {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sp-item-body {
            padding: 16px;
        }

        .sp-section-label {
            font-size: 12px;
            font-weight: 650;
            color: var(--sp-text-secondary);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin: 0 0 10px;
        }

        .sp-divider {
            border: 0;
            border-top: 1px solid var(--sp-border);
            margin: 22px 0;
        }

        .sp-mini-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: var(--sp-radius-sm);
            border: 1px solid var(--sp-border);
            background: var(--sp-surface);
            color: var(--sp-text-secondary);
            cursor: pointer;
            font-size: 12px;
            transition: all .15s;
        }

        .sp-mini-btn:hover {
            background: var(--sp-bg);
            color: var(--sp-text-primary);
        }

        .sp-mini-btn.danger:hover {
            background: var(--sp-red-bg);
            color: var(--sp-red);
            border-color: #f5c0c0;
        }

        .sp-check {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--sp-text-secondary);
            cursor: pointer;
            margin: 0;
        }

        .sp-check input {
            width: 15px;
            height: 15px;
            accent-color: var(--sp-accent);
            cursor: pointer;
        }

        .sp-add-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 2px dashed var(--sp-border);
            border-radius: var(--sp-radius-lg);
            background: transparent;
            color: var(--sp-text-secondary);
            font-size: 13px;
            font-weight: 600;
            padding: 11px;
            cursor: pointer;
            font-family: var(--sp-font);
            transition: all .15s;
        }

        .sp-add-btn:hover {
            border-color: var(--sp-accent);
            background: var(--sp-accent-light);
            color: var(--sp-accent);
        }

        .sp-alert-ok {
            background: var(--sp-green-bg);
            color: var(--sp-green);
            border: 1px solid rgba(0, 122, 94, .2);
            border-radius: var(--sp-radius-md);
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .sp-action-bar {
            background: var(--sp-surface);
            border: 1px solid var(--sp-border);
            border-radius: var(--sp-radius-lg);
            box-shadow: var(--sp-shadow-card);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            position: sticky;
            bottom: 12px;
            z-index: 5;
            position: static;
        }

        .sp-btn-primary,
        .sp-btn-light {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: var(--sp-radius-md);
            font-size: 13.5px;
            font-weight: 580;
            font-family: var(--sp-font);
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: background .15s;
        }

        .sp-btn-primary {
            background: var(--sp-accent);
            color: #fff;
        }

        .sp-btn-primary:hover:not(:disabled) {
            background: var(--sp-accent-hover);
            color: #fff;
        }

        .sp-btn-primary:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        .sp-btn-light {
            background: var(--sp-surface);
            color: var(--sp-text-secondary);
            border-color: var(--sp-border);
        }

        .sp-btn-light:hover {
            background: var(--sp-bg);
            color: var(--sp-text-primary);
        }

        @media (max-width: 768px) {
            .sp-page {
                padding: 16px;
            }
        }
    </style>

    @php
        $stepsData = old('steps', $steps->map(fn($s) => [
            'title' => $s->title,
            'description' => $s->description,
            'color' => $s->color,
            'status' => $s->status,
        ])->values()->all());

        $categoriesData = old('categories', $options->get('category', collect())->map(fn($o) => [
            'label' => $o->label,
            'value' => $o->value,
            'base_min' => $o->base_min,
            'base_max' => $o->base_max,
            'status' => $o->status,
        ])->values()->all());

        $conditionsData = old('conditions', $options->get('condition', collect())->map(fn($o) => [
            'label' => $o->label,
            'value' => $o->value,
            'min_multiplier' => $o->min_multiplier,
            'max_multiplier' => $o->max_multiplier,
            'status' => $o->status,
        ])->values()->all());

        $brandsData = old('brands', $brands->map(fn($b) => [
            'keyword' => $b->keyword,
            'add_min' => $b->add_min,
            'add_max' => $b->add_max,
            'status' => $b->status,
        ])->values()->all());

        $optionText = fn($type) => old(
            "options.$type",
            $options->get($type, collect())
                ->map(fn($o) => $o->label === $o->value ? $o->label : $o->label . ' | ' . $o->value)
                ->implode("\n")
        );
    @endphp

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Manage Device Exchange Page</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Device Exchange</span>
                    </div>
                </div>
                <a href="{{ route('admin.exchange-requests.index') }}" class="sp-btn-light">
                    <i class="fa fa-list"></i> Valuation Requests
                </a>
            </div>

            @if(session('success'))
                <div class="sp-alert-ok"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="font-size:13px">
                    <ul style="margin:0;padding-left:18px">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="exchangeForm" method="POST" action="{{ route('admin.exchange-page.update') }}">
                @csrf
                @method('PUT')

                <!-- SEO -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>SEO</h5>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-field">
                            <label class="sp-label">Meta Title</label>
                            <input type="text" name="meta_title" class="sp-input"
                                value="{{ old('meta_title', $page->meta_title) }}">
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Meta Description</label>
                            <textarea name="meta_description" class="sp-textarea"
                                rows="2">{{ old('meta_description', $page->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- HERO -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Hero Section</h5>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Badge</label>
                                <input type="text" name="hero_badge" class="sp-input"
                                    value="{{ old('hero_badge', $page->hero_badge) }}" placeholder="SMART TRADE-IN">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Title</label>
                                <input type="text" name="hero_title" class="sp-input"
                                    value="{{ old('hero_title', $page->hero_title) }}">
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea name="hero_description" class="sp-textarea"
                                rows="3">{{ old('hero_description', $page->hero_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- STEPS -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>How It Works (Steps)</h5>
                        <p>Shown as numbered cards on the page. Numbers follow the order below.</p>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Section Badge</label>
                                <input type="text" name="steps_badge" class="sp-input"
                                    value="{{ old('steps_badge', $page->steps_badge) }}" placeholder="How It Works">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Section Title</label>
                                <input type="text" name="steps_title" class="sp-input"
                                    value="{{ old('steps_title', $page->steps_title) }}">
                            </div>
                        </div>
                        <div id="list-steps" class="sp-list"></div>
                        <button type="button" class="sp-add-btn" onclick="mountItem('steps', {color:'blue', status:1})">
                            <i class="fa fa-plus"></i> Add Step
                        </button>
                    </div>
                </div>

                <!-- CALCULATOR TEXTS -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Calculator &amp; Result Texts</h5>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Badge</label>
                                <input type="text" name="calc_badge" class="sp-input"
                                    value="{{ old('calc_badge', $page->calc_badge) }}" placeholder="Instant Valuation">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Title</label>
                                <input type="text" name="calc_title" class="sp-input"
                                    value="{{ old('calc_title', $page->calc_title) }}">
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Subtitle</label>
                            <textarea name="calc_subtitle" class="sp-textarea"
                                rows="2">{{ old('calc_subtitle', $page->calc_subtitle) }}</textarea>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Calculate Button Text</label>
                            <input type="text" name="calc_button_text" class="sp-input"
                                value="{{ old('calc_button_text', $page->calc_button_text) }}">
                        </div>

                        <hr class="sp-divider">

                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Result Badge</label>
                                <input type="text" name="result_badge" class="sp-input"
                                    value="{{ old('result_badge', $page->result_badge) }}"
                                    placeholder="ESTIMATED TRADE-IN VALUE">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Result Text</label>
                                <input type="text" name="result_text" class="sp-input"
                                    value="{{ old('result_text', $page->result_text) }}">
                                <div class="sp-hint">Use <strong>{brand}</strong> and <strong>{model}</strong> to insert what
                                    the customer typed.</div>
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Shop Button Text (opens Laptops)</label>
                                <input type="text" name="result_shop_text" class="sp-input"
                                    value="{{ old('result_shop_text', $page->result_shop_text) }}">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Pickup Button Text (opens Contact)</label>
                                <input type="text" name="result_pickup_text" class="sp-input"
                                    value="{{ old('result_pickup_text', $page->result_pickup_text) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DEVICE CATEGORIES (pricing) -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Device Categories &amp; Base Value</h5>
                        <p>Each category is a choice in the "Device Category" dropdown. Base Min / Max (₹) is the starting
                            estimate before brand bonus and condition.</p>
                    </div>
                    <div class="sp-card-body">
                        <div id="list-categories" class="sp-list"></div>
                        <button type="button" class="sp-add-btn" onclick="mountItem('categories', {status:1})">
                            <i class="fa fa-plus"></i> Add Category
                        </button>
                    </div>
                </div>

                <!-- CONDITIONS (multipliers) -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Working Conditions &amp; Multipliers</h5>
                        <p>Final estimate = (base + brand bonus) × multiplier. <strong>1</strong> = no change,
                            <strong>1.20</strong> = +20%, <strong>0.40</strong> = −60%.</p>
                    </div>
                    <div class="sp-card-body">
                        <div id="list-conditions" class="sp-list"></div>
                        <button type="button" class="sp-add-btn"
                            onclick="mountItem('conditions', {min_multiplier:1, max_multiplier:1, status:1})">
                            <i class="fa fa-plus"></i> Add Condition
                        </button>
                    </div>
                </div>

                <!-- BRAND RULES -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Brand Bonus Rules</h5>
                        <p>If the brand typed by the customer contains the keyword, these amounts (₹) are added to the base
                            value. The first matching rule (top to bottom) is used.</p>
                    </div>
                    <div class="sp-card-body">
                        <div id="list-brands" class="sp-list"></div>
                        <button type="button" class="sp-add-btn"
                            onclick="mountItem('brands', {add_min:0, add_max:0, status:1})">
                            <i class="fa fa-plus"></i> Add Brand Rule
                        </button>
                    </div>
                </div>

                <!-- SIMPLE DROPDOWNS -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Other Dropdown Options</h5>
                        <p>One option per line. Use <strong>Label | stored value</strong> if the saved value should differ
                            from what customers see. These do not change the price.</p>
                    </div>
                    <div class="sp-card-body">
                        @foreach(\App\Models\ExchangeOption::TYPES as $type => $label)
                            <div class="sp-field">
                                <label class="sp-label">{{ $label }}</label>
                                <textarea name="options[{{ $type }}]" class="sp-textarea"
                                    rows="5">{{ $optionText($type) }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="sp-action-bar">
                    <button type="submit" id="saveBtn" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Save Exchange Page
                    </button>
                </div>
            </form>

            <!-- ───────── Templates ───────── -->

            <template id="tpl-steps">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Step</div>
                        <div class="sp-item-tools">
                            <label class="sp-check"><input type="checkbox" data-field="status"
                                    name="steps[__I__][status]" value="1"> Visible</label>
                            <button type="button" class="sp-mini-btn" data-action="up" title="Move up"><i
                                    class="fa fa-arrow-up"></i></button>
                            <button type="button" class="sp-mini-btn" data-action="down" title="Move down"><i
                                    class="fa fa-arrow-down"></i></button>
                            <button type="button" class="sp-mini-btn danger" data-action="remove" title="Remove"><i
                                    class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="steps[__I__][title]"
                                    required placeholder="Tell Us About Device">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Color</label>
                                <select class="sp-select" data-field="color" name="steps[__I__][color]">
                                    @foreach($colors as $color)
                                        <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea class="sp-textarea" rows="2" data-field="description"
                                name="steps[__I__][description]"></textarea>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-categories">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Category</div>
                        <div class="sp-item-tools">
                            <label class="sp-check"><input type="checkbox" data-field="status"
                                    name="categories[__I__][status]" value="1"> Visible</label>
                            <button type="button" class="sp-mini-btn" data-action="up" title="Move up"><i
                                    class="fa fa-arrow-up"></i></button>
                            <button type="button" class="sp-mini-btn" data-action="down" title="Move down"><i
                                    class="fa fa-arrow-down"></i></button>
                            <button type="button" class="sp-mini-btn danger" data-action="remove" title="Remove"><i
                                    class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Label <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="label"
                                    name="categories[__I__][label]" required placeholder="Laptop / Notebook">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Stored Value</label>
                                <input type="text" class="sp-input" data-field="value"
                                    name="categories[__I__][value]" placeholder="laptop (auto if empty)">
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Base Min (₹) <span class="sp-req">*</span></label>
                                <input type="number" min="0" class="sp-input" data-field="base_min"
                                    name="categories[__I__][base_min]" required>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Base Max (₹) <span class="sp-req">*</span></label>
                                <input type="number" min="0" class="sp-input" data-field="base_max"
                                    name="categories[__I__][base_max]" required>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-conditions">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Condition</div>
                        <div class="sp-item-tools">
                            <label class="sp-check"><input type="checkbox" data-field="status"
                                    name="conditions[__I__][status]" value="1"> Visible</label>
                            <button type="button" class="sp-mini-btn" data-action="up" title="Move up"><i
                                    class="fa fa-arrow-up"></i></button>
                            <button type="button" class="sp-mini-btn" data-action="down" title="Move down"><i
                                    class="fa fa-arrow-down"></i></button>
                            <button type="button" class="sp-mini-btn danger" data-action="remove" title="Remove"><i
                                    class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Label <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="label"
                                    name="conditions[__I__][label]" required
                                    placeholder="Good (Minor cosmetic scratches, fully working)">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Stored Value</label>
                                <input type="text" class="sp-input" data-field="value"
                                    name="conditions[__I__][value]" placeholder="good (auto if empty)">
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Min Multiplier <span class="sp-req">*</span></label>
                                <input type="number" step="0.01" min="0" max="10" class="sp-input"
                                    data-field="min_multiplier" name="conditions[__I__][min_multiplier]" required>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Max Multiplier <span class="sp-req">*</span></label>
                                <input type="number" step="0.01" min="0" max="10" class="sp-input"
                                    data-field="max_multiplier" name="conditions[__I__][max_multiplier]" required>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-brands">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Brand Rule</div>
                        <div class="sp-item-tools">
                            <label class="sp-check"><input type="checkbox" data-field="status"
                                    name="brands[__I__][status]" value="1"> Active</label>
                            <button type="button" class="sp-mini-btn" data-action="up" title="Move up"><i
                                    class="fa fa-arrow-up"></i></button>
                            <button type="button" class="sp-mini-btn" data-action="down" title="Move down"><i
                                    class="fa fa-arrow-down"></i></button>
                            <button type="button" class="sp-mini-btn danger" data-action="remove" title="Remove"><i
                                    class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="sp-item-body">
                        <div class="sp-row-3">
                            <div class="sp-field">
                                <label class="sp-label">Brand Keyword <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="keyword"
                                    name="brands[__I__][keyword]" required placeholder="apple">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Add Min (₹)</label>
                                <input type="number" min="0" class="sp-input" data-field="add_min"
                                    name="brands[__I__][add_min]">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Add Max (₹)</label>
                                <input type="number" min="0" class="sp-input" data-field="add_max"
                                    name="brands[__I__][add_max]">
                            </div>
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    const counters = { steps: 0, categories: 0, conditions: 0, brands: 0 };

    const initialData = {
        steps: Object.values(@json($stepsData)),
        categories: Object.values(@json($categoriesData)),
        conditions: Object.values(@json($conditionsData)),
        brands: Object.values(@json($brandsData))
    };

    function fillRow(row, data) {
        Object.keys(data || {}).forEach(function (field) {
            const el = row.querySelector('[data-field="' + field + '"]');
            if (!el) return;
            if (el.type === 'checkbox') {
                el.checked = !!Number(data[field]);
            } else {
                el.value = data[field] === null || data[field] === undefined ? '' : data[field];
            }
        });
    }

    function mountItem(type, data) {
        const html = document.getElementById('tpl-' + type).innerHTML.replaceAll('__I__', counters[type]++);
        const holder = document.createElement('div');
        holder.innerHTML = html.trim();
        const row = holder.firstElementChild;

        fillRow(row, data || {});
        document.getElementById('list-' + type).appendChild(row);
        renumberAll();
    }

    function renumberAll() {
        document.querySelectorAll('.sp-list').forEach(function (list) {
            Array.from(list.children).forEach(function (row, i) {
                row.querySelector('.sp-item-no').textContent = i + 1;
            });
        });
    }

    $(document).on('click', '[data-action]', function () {
        const row = $(this).closest('.sp-item');
        const act = $(this).data('action');

        if (act === 'remove') row.remove();
        if (act === 'up') row.prev('.sp-item').before(row);
        if (act === 'down') row.next('.sp-item').after(row);

        renumberAll();
    });

    Object.keys(initialData).forEach(function (type) {
        initialData[type].forEach(function (item) { mountItem(type, item); });
    });

    document.getElementById('exchangeForm').addEventListener('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    });
</script>