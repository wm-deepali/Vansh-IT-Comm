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

        .sp-page { background: var(--sp-bg); padding: 24px 28px; min-height: 100vh; font-family: var(--sp-font); color: var(--sp-text-primary); font-size: 14px; }
        .sp-page * { box-sizing: border-box; }
        .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .sp-page-title { font-size: 20px; font-weight: 660; margin: 0 0 4px; letter-spacing: -.2px; }
        .sp-crumb { font-size: 12.5px; color: var(--sp-text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
        .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
        .sp-crumb a:hover { text-decoration: underline; }

        .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
        .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; }
        .sp-card-header h5 { font-size: 13px; font-weight: 650; margin: 0; }
        .sp-card-header p { font-size: 11.5px; color: var(--sp-text-hint); margin: 2px 0 0; }
        .sp-card-body { padding: 20px 24px; }

        .sp-field { margin-bottom: 18px; }
        .sp-field:last-child { margin-bottom: 0; }
        .sp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .sp-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        @media (max-width: 700px) { .sp-row, .sp-row-3 { grid-template-columns: 1fr; } }

        .sp-label { display: block; font-size: 12px; font-weight: 620; color: var(--sp-text-secondary); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 6px; }
        .sp-req { color: var(--sp-red); margin-left: 2px; }
        .sp-hint { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; }

        .sp-input, .sp-textarea, .sp-select { width: 100%; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 12px; font-size: 13.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--sp-font); }
        .sp-input, .sp-select { height: 38px; }
        .sp-textarea { padding: 10px 12px; resize: vertical; min-height: 80px; line-height: 1.6; }
        .sp-input:focus, .sp-textarea:focus, .sp-select:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48, 61, 137, .10); }

        .sp-icon-input-wrap { display: flex; align-items: center; gap: 8px; }
        .sp-icon-preview { width: 38px; height: 38px; flex-shrink: 0; border-radius: var(--sp-radius-md); background: var(--sp-accent-light); border: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: center; color: var(--sp-accent); font-size: 16px; }

        .sp-item { border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); margin-bottom: 12px; background: var(--sp-surface); overflow: hidden; }
        .sp-item-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 8px 14px; background: #fafafa; border-bottom: 1px solid var(--sp-border); }
        .sp-item-title { font-size: 12.5px; font-weight: 650; display: flex; align-items: center; gap: 8px; }
        .sp-item-no { display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; background: var(--sp-accent-light); color: var(--sp-accent); font-size: 11px; font-weight: 700; }
        .sp-item-tools { display: flex; align-items: center; gap: 6px; }
        .sp-item-body { padding: 16px; }

        .sec-label { font-size: 12px; font-weight: 650; color: var(--sp-text-secondary); text-transform: uppercase; letter-spacing: .04em; margin: 18px 0 8px; padding-top: 14px; border-top: 1px dashed var(--sp-border); }
        .sec-label:first-child { margin-top: 0; padding-top: 0; border-top: 0; }

        .sp-mini-btn { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: var(--sp-radius-sm); border: 1px solid var(--sp-border); background: var(--sp-surface); color: var(--sp-text-secondary); cursor: pointer; font-size: 12px; transition: all .15s; }
        .sp-mini-btn:hover { background: var(--sp-bg); color: var(--sp-text-primary); }
        .sp-mini-btn.danger:hover { background: var(--sp-red-bg); color: var(--sp-red); border-color: #f5c0c0; }

        .sp-check { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--sp-text-secondary); cursor: pointer; margin: 0; }
        .sp-check input { width: 15px; height: 15px; accent-color: var(--sp-accent); cursor: pointer; }

        .sp-add-btn { width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; border: 2px dashed var(--sp-border); border-radius: var(--sp-radius-lg); background: transparent; color: var(--sp-text-secondary); font-size: 13px; font-weight: 600; padding: 11px; cursor: pointer; font-family: var(--sp-font); transition: all .15s; }
        .sp-add-btn:hover { border-color: var(--sp-accent); background: var(--sp-accent-light); color: var(--sp-accent); }

        .sp-alert-ok { background: var(--sp-green-bg); color: var(--sp-green); border: 1px solid rgba(0, 122, 94, .2); border-radius: var(--sp-radius-md); padding: 10px 16px; font-size: 13px; font-weight: 500; margin-bottom: 16px; }

        .sp-action-bar { background: var(--sp-surface); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; margin-top: 20px; position: sticky; bottom: 12px; z-index: 5; position: static; }
        .sp-btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: var(--sp-radius-md); font-size: 13.5px; font-weight: 580; font-family: var(--sp-font); cursor: pointer; background: var(--sp-accent); color: #fff; border: 1px solid transparent; transition: background .15s; }
        .sp-btn-primary:hover:not(:disabled) { background: var(--sp-accent-hover); }
        .sp-btn-primary:disabled { opacity: .65; cursor: not-allowed; }

        /* tabs */
        .hp-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
        .hp-tab-btn { border: 1px solid var(--sp-border); background: var(--sp-surface); color: var(--sp-text-secondary); font-size: 12.5px; font-weight: 600; padding: 7px 14px; border-radius: 999px; cursor: pointer; font-family: var(--sp-font); transition: all .15s; }
        .hp-tab-btn:hover { border-color: var(--sp-accent); color: var(--sp-accent); }
        .hp-tab-btn.active { background: var(--sp-accent); border-color: var(--sp-accent); color: #fff; }
        .hp-tab { display: none; }
        .hp-tab.active { display: block; }

        .hp-img-preview { margin-top: 8px; max-height: 90px; border-radius: var(--sp-radius-sm); border: 1px solid var(--sp-border); display: none; }

        @media (max-width: 768px) { .sp-page { padding: 16px; } }
    </style>

    @php
        /** helper: array of rows => "a | b | c" lines for textareas */
        $pipe = fn($rows, array $keys) => collect($rows ?? [])
            ->map(fn($r) => collect($keys)->map(fn($k) => $r[$k] ?? '')->implode(' | '))
            ->implode("\n");

        $slidesData = old('slides', $slides->map(fn($s) => [
            'badge_text' => $s->badge_text, 'badge_icon' => $s->badge_icon, 'theme' => $s->theme,
            'title_line_1' => $s->title_line_1, 'title_highlight' => $s->title_highlight, 'description' => $s->description,
            'btn_primary_text' => $s->btn_primary_text, 'btn_primary_icon' => $s->btn_primary_icon, 'btn_primary_link' => $s->linkValue('btn_primary'),
            'btn_secondary_text' => $s->btn_secondary_text, 'btn_secondary_icon' => $s->btn_secondary_icon, 'btn_secondary_link' => $s->linkValue('btn_secondary'),
            'link_text' => $s->link_text, 'link_link' => $s->linkValue('link'),
            'trust_points' => $pipe($s->trust_points, ['icon', 'color', 'text']),
            'card_image' => $s->card_image, 'card_image_alt' => $s->card_image_alt,
            'card_top_badge' => $s->card_top_badge, 'card_bottom_badge' => $s->card_bottom_badge,
            'card_label' => $s->card_label, 'card_title' => $s->card_title, 'card_subtitle' => $s->card_subtitle,
            'card_old_price' => $s->card_old_price, 'card_price' => $s->card_price,
            'is_active' => $s->is_active ? 1 : 0,
        ])->values()->all());

        $featureMap = fn($c) => $c->map(fn($f) => [
            'icon' => $f->icon, 'color' => $f->color, 'title' => $f->title,
            'subtitle' => $f->subtitle, 'is_active' => $f->is_active ? 1 : 0,
        ])->values()->all();

        $trustData  = old('trust', $featureMap($trustItems));
        $whyData    = old('why', $featureMap($whyItems));

        $budgetData = old('budget', $budgetCards->map(fn($b) => [
            'label' => $b->label, 'title' => $b->title, 'description' => $b->description,
            'min_price' => $b->min_price, 'max_price' => $b->max_price, 'button_text' => $b->button_text,
            'gradient' => $b->gradient, 'label_color' => $b->label_color, 'button_color' => $b->button_color,
            'is_active' => $b->is_active ? 1 : 0,
        ])->values()->all());

        $guidedData = old('guided', $guided->map(fn($g) => [
            'icon' => $g->icon, 'color' => $g->color, 'badge' => $g->badge, 'title' => $g->title,
            'description' => $g->description, 'features' => implode("\n", $g->features ?? []),
            'button_text' => $g->button_text, 'button_link' => $g->linkValue('button'),
            'is_active' => $g->is_active ? 1 : 0,
        ])->values()->all());

        $stepsData = old('steps', $steps->map(fn($s) => [
            'title' => $s->title, 'description' => $s->description, 'color' => $s->color,
            'is_active' => $s->is_active ? 1 : 0,
        ])->values()->all());

        $storesData = old('stores', $stores->map(fn($s) => [
            'icon' => $s->icon, 'color' => $s->color, 'badge' => $s->badge, 'title' => $s->title,
            'address' => $s->address, 'phone' => $s->phone, 'details' => $pipe($s->details, ['icon', 'text']),
            'button_text' => $s->button_text, 'button_link' => $s->linkValue('button'),
            'is_active' => $s->is_active ? 1 : 0,
        ])->values()->all());

        $ctaHints = [
            'brand_philosophy' => 'One point per line:  icon | color class | text   e.g.  fa-solid fa-circle-check | text-blue-400 | <strong>New</strong> when you want the latest release.',
            'repair_cta'       => 'One fix per line:  icon | color class | text | right-side tag   e.g.  fa-solid fa-display | text-blue-400 | Screen Replacement | Same Day Available',
            'exchange_cta'     => 'Not used for this block.',
            'final_cta'        => 'Not used for this block.',
        ];
    @endphp

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Manage Home Page</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Home Page</span>
                    </div>
                </div>
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

            <datalist id="iconList">
                <option value="fa-solid fa-bolt">
                <option value="fa-solid fa-percent">
                <option value="fa-solid fa-mobile-screen">
                <option value="fa-solid fa-laptop">
                <option value="fa-solid fa-mobile-screen-button">
                <option value="fa-solid fa-clipboard-check">
                <option value="fa-solid fa-receipt">
                <option value="fa-solid fa-shield-halved">
                <option value="fa-solid fa-box-open">
                <option value="fa-solid fa-headset">
                <option value="fa-solid fa-truck-fast">
                <option value="fa-solid fa-screwdriver-wrench">
                <option value="fa-solid fa-wrench">
                <option value="fa-solid fa-store">
                <option value="fa-solid fa-warehouse">
                <option value="fa-solid fa-repeat">
                <option value="fa-solid fa-fire">
                <option value="fa-solid fa-calculator">
                <option value="fa-solid fa-comments">
                <option value="fa-solid fa-circle-check">
            </datalist>

            <datalist id="linkList">
                <option value="shop">
                <option value="repair">
                <option value="exchange">
                <option value="contact">
                <option value="user.track-order">
            </datalist>

            <div class="hp-tabs" id="hpTabs">
                <button type="button" class="hp-tab-btn active" data-tab="headings">Section Headings</button>
                <button type="button" class="hp-tab-btn" data-tab="hero">Hero Slider</button>
                <button type="button" class="hp-tab-btn" data-tab="trust">Trust Strip</button>
                <button type="button" class="hp-tab-btn" data-tab="budget">Budget Cards</button>
                <button type="button" class="hp-tab-btn" data-tab="guided">Guided Options</button>
                <button type="button" class="hp-tab-btn" data-tab="steps">How We Refurbish</button>
                <button type="button" class="hp-tab-btn" data-tab="why">Why Choose Us</button>
                <button type="button" class="hp-tab-btn" data-tab="cta">CTA Blocks</button>
                <button type="button" class="hp-tab-btn" data-tab="stores">Store Locations</button>
            </div>

            <form id="homeForm" method="POST" action="{{ route('admin.home-page.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- ───────── SECTION HEADINGS ───────── -->
                <div class="hp-tab active" data-tab="headings">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Section Headings</h5>
                            <p>Small heading, title, subtitle and "view all" link of each product / info section. Untick "Visible" to hide a whole section.</p>
                        </div>
                        <div class="sp-card-body">
                            @foreach($headingKeys as $key => $label)
                                @php $h = $headings->get($key); @endphp
                                <div class="sp-item">
                                    <div class="sp-item-head">
                                        <div class="sp-item-title">{{ $label }}</div>
                                        <div class="sp-item-tools">
                                            <label class="sp-check">
                                                <input type="checkbox" name="headings[{{ $key }}][is_active]" value="1"
                                                    {{ old("headings.$key.is_active", $h ? $h->is_active : true) ? 'checked' : '' }}> Visible
                                            </label>
                                        </div>
                                    </div>
                                    <div class="sp-item-body">
                                        <div class="sp-row">
                                            <div class="sp-field">
                                                <label class="sp-label">Small heading</label>
                                                <input type="text" class="sp-input" name="headings[{{ $key }}][eyebrow]"
                                                    value="{{ old("headings.$key.eyebrow", $h->eyebrow ?? '') }}">
                                            </div>
                                            <div class="sp-field">
                                                <label class="sp-label">Title</label>
                                                <input type="text" class="sp-input" name="headings[{{ $key }}][title]"
                                                    value="{{ old("headings.$key.title", $h->title ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="sp-field">
                                            <label class="sp-label">Subtitle</label>
                                            <input type="text" class="sp-input" name="headings[{{ $key }}][subtitle]"
                                                value="{{ old("headings.$key.subtitle", $h->subtitle ?? '') }}">
                                        </div>
                                        <div class="sp-row">
                                            <div class="sp-field">
                                                <label class="sp-label">Link text</label>
                                                <input type="text" class="sp-input" name="headings[{{ $key }}][link_text]"
                                                    value="{{ old("headings.$key.link_text", $h->link_text ?? '') }}" placeholder="View All">
                                            </div>
                                            <div class="sp-field">
                                                <label class="sp-label">Link (route name or URL)</label>
                                                <input type="text" class="sp-input" list="linkList" name="headings[{{ $key }}][link_link]"
                                                    value="{{ old("headings.$key.link_link", $h ? $h->linkValue('link') : '') }}" placeholder="shop">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- ───────── HERO SLIDER ───────── -->
                <div class="hp-tab" data-tab="hero">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Hero Slider</h5>
                            <p>Each slide has a text side (left) and a product card (right).</p>
                        </div>
                        <div class="sp-card-body">
                            <div id="list-slides"></div>
                            <button type="button" class="sp-add-btn" onclick="mount('list-slides','tpl-slide',{theme:'blue',is_active:1})">
                                <i class="fa fa-plus"></i> Add Slide
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ───────── TRUST STRIP ───────── -->
                <div class="hp-tab" data-tab="trust">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Trust Strip</h5>
                            <p>The row of badges under the hero (20+ Point Tested, GST Invoice ...).</p>
                        </div>
                        <div class="sp-card-body">
                            <div id="list-trust"></div>
                            <button type="button" class="sp-add-btn" onclick="mount('list-trust','tpl-feature',{color:'blue',is_active:1},'trust')">
                                <i class="fa fa-plus"></i> Add Badge
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ───────── BUDGET CARDS ───────── -->
                <div class="hp-tab" data-tab="budget">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Shop Laptops By Budget</h5>
                            <p>Each card links to the shop filtered by the min / max price.</p>
                        </div>
                        <div class="sp-card-body">
                            <div id="list-budget"></div>
                            <button type="button" class="sp-add-btn" onclick="mount('list-budget','tpl-budget',{button_text:'View Products →',is_active:1})">
                                <i class="fa fa-plus"></i> Add Budget Card
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ───────── GUIDED ───────── -->
                <div class="hp-tab" data-tab="guided">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Guided Recommendation Cards</h5>
                            <p>"Need a Laptop? / Need a Phone? / Need a Repair?" cards.</p>
                        </div>
                        <div class="sp-card-body">
                            <div id="list-guided"></div>
                            <button type="button" class="sp-add-btn" onclick="mount('list-guided','tpl-guided',{color:'blue',icon:'fa-solid fa-laptop',is_active:1})">
                                <i class="fa fa-plus"></i> Add Card
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ───────── PROCESS STEPS ───────── -->
                <div class="hp-tab" data-tab="steps">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>How We Refurbish</h5>
                            <p>Step numbers follow the order below.</p>
                        </div>
                        <div class="sp-card-body">
                            <div id="list-steps"></div>
                            <button type="button" class="sp-add-btn" onclick="mount('list-steps','tpl-step',{color:'blue',is_active:1})">
                                <i class="fa fa-plus"></i> Add Step
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ───────── WHY US ───────── -->
                <div class="hp-tab" data-tab="why">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Why Choose Us</h5>
                            <p>Icon cards in the "Why VANSH IT & COMM" section.</p>
                        </div>
                        <div class="sp-card-body">
                            <div id="list-why"></div>
                            <button type="button" class="sp-add-btn" onclick="mount('list-why','tpl-feature',{color:'blue',is_active:1},'why')">
                                <i class="fa fa-plus"></i> Add Card
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ───────── CTA BLOCKS ───────── -->
                <div class="hp-tab" data-tab="cta">
                    @foreach($ctaKeys as $key => $label)
                        @php $b = $ctaBlocks->get($key); @endphp
                        <div class="sp-card">
                            <div class="sp-card-header" style="display:flex;justify-content:space-between;align-items:center">
                                <h5>{{ $label }}</h5>
                                <label class="sp-check">
                                    <input type="checkbox" name="cta[{{ $key }}][is_active]" value="1"
                                        {{ old("cta.$key.is_active", $b ? $b->is_active : true) ? 'checked' : '' }}> Visible
                                </label>
                            </div>
                            <div class="sp-card-body">
                                <div class="sp-row">
                                    <div class="sp-field">
                                        <label class="sp-label">Badge</label>
                                        <input type="text" class="sp-input" name="cta[{{ $key }}][badge_text]"
                                            value="{{ old("cta.$key.badge_text", $b->badge_text ?? '') }}">
                                    </div>
                                    <div class="sp-field">
                                        <label class="sp-label">Title</label>
                                        <input type="text" class="sp-input" name="cta[{{ $key }}][title]"
                                            value="{{ old("cta.$key.title", $b->title ?? '') }}">
                                    </div>
                                </div>
                                <div class="sp-field">
                                    <label class="sp-label">Description</label>
                                    <textarea class="sp-textarea" rows="2" name="cta[{{ $key }}][description]">{{ old("cta.$key.description", $b->description ?? '') }}</textarea>
                                </div>

                                @foreach([1, 2, 3] as $n)
                                    <div class="sp-row-3" style="margin-bottom:14px">
                                        <div>
                                            <label class="sp-label">Button {{ $n }} text</label>
                                            <input type="text" class="sp-input" name="cta[{{ $key }}][btn_{{ $n }}_text]"
                                                value="{{ old("cta.$key.btn_{$n}_text", $b->{"btn_{$n}_text"} ?? '') }}">
                                        </div>
                                        <div>
                                            <label class="sp-label">Button {{ $n }} icon</label>
                                            <input type="text" class="sp-input" list="iconList" name="cta[{{ $key }}][btn_{{ $n }}_icon]"
                                                value="{{ old("cta.$key.btn_{$n}_icon", $b->{"btn_{$n}_icon"} ?? '') }}">
                                        </div>
                                        <div>
                                            <label class="sp-label">Button {{ $n }} link</label>
                                            <input type="text" class="sp-input" list="linkList" name="cta[{{ $key }}][btn_{{ $n }}_link]"
                                                value="{{ old("cta.$key.btn_{$n}_link", $b ? $b->linkValue("btn_$n") : '') }}">
                                        </div>
                                    </div>
                                @endforeach
                                <div class="sp-hint" style="margin-bottom:14px">Leave a button text empty to hide that button.</div>

                                <div class="sp-field">
                                    <label class="sp-label">List items</label>
                                    <textarea class="sp-textarea" rows="5" name="cta[{{ $key }}][items]">{{ old("cta.$key.items", $pipe($b->items ?? [], ['icon', 'color', 'text', 'tag'])) }}</textarea>
                                    <div class="sp-hint">{{ $ctaHints[$key] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- ───────── STORES ───────── -->
                <div class="hp-tab" data-tab="stores">
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h5>Store Locations & Hubs</h5>
                        </div>
                        <div class="sp-card-body">
                            <div id="list-stores"></div>
                            <button type="button" class="sp-add-btn" onclick="mount('list-stores','tpl-store',{color:'blue',icon:'fa-solid fa-store',is_active:1})">
                                <i class="fa fa-plus"></i> Add Location
                            </button>
                        </div>
                    </div>
                </div>

                <div class="sp-action-bar">
                    <button type="submit" id="saveBtn" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Save Home Page
                    </button>
                </div>
            </form>

            @php
                $colorOptions = collect($colors)->map(fn($c) => '<option value="' . $c . '">' . ucfirst($c) . '</option>')->implode('');
                $itemHead = function (string $label) {
                    return '<div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> ' . $label . '</div>
                        <div class="sp-item-tools">
                            <label class="sp-check"><input type="checkbox" data-field="is_active" name="__P__[__I__][is_active]" value="1"> Visible</label>
                            <button type="button" class="sp-mini-btn" data-action="up" title="Move up"><i class="fa fa-arrow-up"></i></button>
                            <button type="button" class="sp-mini-btn" data-action="down" title="Move down"><i class="fa fa-arrow-down"></i></button>
                            <button type="button" class="sp-mini-btn danger" data-action="remove" title="Remove"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>';
                };
            @endphp

            <!-- ───────── Templates (__P__ = input name prefix, __I__ = row index) ───────── -->

            <template id="tpl-slide">
                <div class="sp-item" data-prefix="slides">
                    {!! str_replace('__P__', 'slides', $itemHead('Slide')) !!}
                    <div class="sp-item-body">
                        <div class="sec-label">Text side</div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Badge text</label>
                                <input type="text" class="sp-input" data-field="badge_text" name="slides[__I__][badge_text]">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Badge icon</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" list="iconList" data-field="badge_icon" name="slides[__I__][badge_icon]">
                                </div>
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Title line 1 <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title_line_1" name="slides[__I__][title_line_1]" placeholder="TECH THAT WORKS">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Highlighted title (gradient)</label>
                                <input type="text" class="sp-input" data-field="title_highlight" name="slides[__I__][title_highlight]" placeholder="FOR YOU.">
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Color theme</label>
                                <select class="sp-select" data-field="theme" name="slides[__I__][theme]">{!! $colorOptions !!}</select>
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea class="sp-textarea" rows="2" data-field="description" name="slides[__I__][description]"></textarea>
                        </div>

                        <div class="sec-label">Buttons</div>
                        <div class="sp-row-3">
                            <div class="sp-field"><label class="sp-label">Primary text</label>
                                <input type="text" class="sp-input" data-field="btn_primary_text" name="slides[__I__][btn_primary_text]"></div>
                            <div class="sp-field"><label class="sp-label">Primary icon</label>
                                <input type="text" class="sp-input" list="iconList" data-field="btn_primary_icon" name="slides[__I__][btn_primary_icon]"></div>
                            <div class="sp-field"><label class="sp-label">Primary link</label>
                                <input type="text" class="sp-input" list="linkList" data-field="btn_primary_link" name="slides[__I__][btn_primary_link]"></div>
                        </div>
                        <div class="sp-row-3">
                            <div class="sp-field"><label class="sp-label">Secondary text</label>
                                <input type="text" class="sp-input" data-field="btn_secondary_text" name="slides[__I__][btn_secondary_text]"></div>
                            <div class="sp-field"><label class="sp-label">Secondary icon</label>
                                <input type="text" class="sp-input" list="iconList" data-field="btn_secondary_icon" name="slides[__I__][btn_secondary_icon]"></div>
                            <div class="sp-field"><label class="sp-label">Secondary link</label>
                                <input type="text" class="sp-input" list="linkList" data-field="btn_secondary_link" name="slides[__I__][btn_secondary_link]"></div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Text link</label>
                                <input type="text" class="sp-input" data-field="link_text" name="slides[__I__][link_text]" placeholder="Need a Repair? Book Now →"></div>
                            <div class="sp-field"><label class="sp-label">Text link target</label>
                                <input type="text" class="sp-input" list="linkList" data-field="link_link" name="slides[__I__][link_link]"></div>
                        </div>
                        <div class="sp-hint" style="margin:-6px 0 14px">Link = a route name (shop, repair, exchange, contact) or a full URL / #anchor. Empty text hides the button.</div>

                        <div class="sp-field">
                            <label class="sp-label">Trust points (under buttons)</label>
                            <textarea class="sp-textarea" rows="3" data-field="trust_points" name="slides[__I__][trust_points]"></textarea>
                            <div class="sp-hint">One per line: icon | color class | text &nbsp; e.g. fa-solid fa-circle-check | text-emerald-400 | Up to 12-Mo Warranty</div>
                        </div>

                        <div class="sec-label">Product card (right side)</div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Image</label>
                                <input type="file" class="sp-input" style="padding-top:7px" accept="image/*" data-image-input name="slides[__I__][card_image_file]">
                                <input type="hidden" data-field="card_image" name="slides[__I__][card_image]">
                                <img class="hp-img-preview" alt="">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Image alt text</label>
                                <input type="text" class="sp-input" data-field="card_image_alt" name="slides[__I__][card_image_alt]">
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Top badge</label>
                                <input type="text" class="sp-input" data-field="card_top_badge" name="slides[__I__][card_top_badge]" placeholder="🔥 Best Seller • 64% OFF"></div>
                            <div class="sp-field"><label class="sp-label">Bottom badge</label>
                                <input type="text" class="sp-input" data-field="card_bottom_badge" name="slides[__I__][card_bottom_badge]" placeholder="20-Point Verified"></div>
                        </div>
                        <div class="sp-row-3">
                            <div class="sp-field"><label class="sp-label">Label</label>
                                <input type="text" class="sp-input" data-field="card_label" name="slides[__I__][card_label]" placeholder="Enterprise Grade"></div>
                            <div class="sp-field"><label class="sp-label">Product title</label>
                                <input type="text" class="sp-input" data-field="card_title" name="slides[__I__][card_title]"></div>
                            <div class="sp-field"><label class="sp-label">Specs line</label>
                                <input type="text" class="sp-input" data-field="card_subtitle" name="slides[__I__][card_subtitle]"></div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Old price</label>
                                <input type="text" class="sp-input" data-field="card_old_price" name="slides[__I__][card_old_price]" placeholder="₹89,999"></div>
                            <div class="sp-field"><label class="sp-label">Price</label>
                                <input type="text" class="sp-input" data-field="card_price" name="slides[__I__][card_price]" placeholder="₹32,499"></div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-feature">
                <div class="sp-item">
                    {!! $itemHead('Item') !!}
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="__P__[__I__][title]">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Sub text</label>
                                <input type="text" class="sp-input" data-field="subtitle" name="__P__[__I__][subtitle]">
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Icon</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" list="iconList" data-field="icon" name="__P__[__I__][icon]">
                                </div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Color</label>
                                <select class="sp-select" data-field="color" name="__P__[__I__][color]">{!! $colorOptions !!}</select>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-budget">
                <div class="sp-item">
                    {!! str_replace('__P__', 'budget', $itemHead('Budget card')) !!}
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Small label</label>
                                <input type="text" class="sp-input" data-field="label" name="budget[__I__][label]" placeholder="Entry & Students"></div>
                            <div class="sp-field"><label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="budget[__I__][title]" placeholder="Laptops Under ₹15,000"></div>
                        </div>
                        <div class="sp-field"><label class="sp-label">Description</label>
                            <textarea class="sp-textarea" rows="2" data-field="description" name="budget[__I__][description]"></textarea></div>
                        <div class="sp-row-3">
                            <div class="sp-field"><label class="sp-label">Min price (₹)</label>
                                <input type="number" min="0" class="sp-input" data-field="min_price" name="budget[__I__][min_price]"></div>
                            <div class="sp-field"><label class="sp-label">Max price (₹)</label>
                                <input type="number" min="0" class="sp-input" data-field="max_price" name="budget[__I__][max_price]"></div>
                            <div class="sp-field"><label class="sp-label">Button text</label>
                                <input type="text" class="sp-input" data-field="button_text" name="budget[__I__][button_text]"></div>
                        </div>
                        <div class="sp-row-3">
                            <div class="sp-field"><label class="sp-label">Card gradient (Tailwind)</label>
                                <input type="text" class="sp-input" data-field="gradient" name="budget[__I__][gradient]" placeholder="from-blue-900 to-slate-900"></div>
                            <div class="sp-field"><label class="sp-label">Label color (Tailwind)</label>
                                <input type="text" class="sp-input" data-field="label_color" name="budget[__I__][label_color]" placeholder="text-emerald-400"></div>
                            <div class="sp-field"><label class="sp-label">Button color (Tailwind)</label>
                                <input type="text" class="sp-input" data-field="button_color" name="budget[__I__][button_color]" placeholder="bg-blue-600"></div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-guided">
                <div class="sp-item">
                    {!! str_replace('__P__', 'guided', $itemHead('Card')) !!}
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="guided[__I__][title]" placeholder="Need a Laptop?"></div>
                            <div class="sp-field"><label class="sp-label">Badge</label>
                                <input type="text" class="sp-input" data-field="badge" name="guided[__I__][badge]" placeholder="High Performance"></div>
                        </div>
                        <div class="sp-field"><label class="sp-label">Description</label>
                            <textarea class="sp-textarea" rows="2" data-field="description" name="guided[__I__][description]"></textarea></div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Icon</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" list="iconList" data-field="icon" name="guided[__I__][icon]">
                                </div>
                            </div>
                            <div class="sp-field"><label class="sp-label">Color</label>
                                <select class="sp-select" data-field="color" name="guided[__I__][color]">{!! $colorOptions !!}</select></div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Feature bullets</label>
                            <textarea class="sp-textarea" rows="3" data-field="features" name="guided[__I__][features]"></textarea>
                            <div class="sp-hint">One per line. You can use &lt;strong&gt;bold&lt;/strong&gt;.</div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Button text</label>
                                <input type="text" class="sp-input" data-field="button_text" name="guided[__I__][button_text]" placeholder="Find My Laptop"></div>
                            <div class="sp-field"><label class="sp-label">Button link (route name or URL)</label>
                                <input type="text" class="sp-input" list="linkList" data-field="button_link" name="guided[__I__][button_link]"></div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-step">
                <div class="sp-item">
                    {!! str_replace('__P__', 'steps', $itemHead('Step')) !!}
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="steps[__I__][title]" placeholder="Hardware Test"></div>
                            <div class="sp-field"><label class="sp-label">Number color</label>
                                <select class="sp-select" data-field="color" name="steps[__I__][color]">{!! $colorOptions !!}</select></div>
                        </div>
                        <div class="sp-field"><label class="sp-label">Description</label>
                            <input type="text" class="sp-input" data-field="description" name="steps[__I__][description]"></div>
                    </div>
                </div>
            </template>

            <template id="tpl-store">
                <div class="sp-item">
                    {!! str_replace('__P__', 'stores', $itemHead('Location')) !!}
                    <div class="sp-item-body">
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="stores[__I__][title]" placeholder="Main Experience Store"></div>
                            <div class="sp-field"><label class="sp-label">Badge</label>
                                <input type="text" class="sp-input" data-field="badge" name="stores[__I__][badge]" placeholder="Retail Store"></div>
                        </div>
                        <div class="sp-field"><label class="sp-label">Address / tagline</label>
                            <input type="text" class="sp-input" data-field="address" name="stores[__I__][address]"></div>
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Phone</label>
                                <input type="text" class="sp-input" data-field="phone" name="stores[__I__][phone]"></div>
                            <div class="sp-field">
                                <label class="sp-label">Icon</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" list="iconList" data-field="icon" name="stores[__I__][icon]">
                                </div>
                            </div>
                        </div>
                        <div class="sp-field"><label class="sp-label">Color</label>
                            <select class="sp-select" data-field="color" name="stores[__I__][color]">{!! $colorOptions !!}</select></div>
                        <div class="sp-field">
                            <label class="sp-label">Detail lines</label>
                            <textarea class="sp-textarea" rows="3" data-field="details" name="stores[__I__][details]"></textarea>
                            <div class="sp-hint">One per line: icon | text &nbsp; e.g. fa-regular fa-clock | Mon – Sat: 10:00 AM – 8:30 PM</div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field"><label class="sp-label">Button text</label>
                                <input type="text" class="sp-input" data-field="button_text" name="stores[__I__][button_text]" placeholder="Contact Store"></div>
                            <div class="sp-field"><label class="sp-label">Button link (route name or URL)</label>
                                <input type="text" class="sp-input" list="linkList" data-field="button_link" name="stores[__I__][button_link]"></div>
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    const ASSET_BASE = @json(rtrim(asset(''), '/') . '/');
    const counters = {};

    const initial = {
        'list-slides': { tpl: 'tpl-slide',   prefix: '',      data: @json(array_values($slidesData)) },
        'list-trust':  { tpl: 'tpl-feature', prefix: 'trust', data: @json(array_values($trustData)) },
        'list-budget': { tpl: 'tpl-budget',  prefix: '',      data: @json(array_values($budgetData)) },
        'list-guided': { tpl: 'tpl-guided',  prefix: '',      data: @json(array_values($guidedData)) },
        'list-steps':  { tpl: 'tpl-step',    prefix: '',      data: @json(array_values($stepsData)) },
        'list-why':    { tpl: 'tpl-feature', prefix: 'why',   data: @json(array_values($whyData)) },
        'list-stores': { tpl: 'tpl-store',   prefix: '',      data: @json(array_values($storesData)) },
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

    function mount(listId, tplId, data, prefix) {
        counters[listId] = counters[listId] || 0;
        const i = counters[listId]++;

        let html = document.getElementById(tplId).innerHTML
            .replaceAll('__I__', i)
            .replaceAll('__P__', prefix || '');

        const holder = document.createElement('div');
        holder.innerHTML = html.trim();
        const row = holder.firstElementChild;

        fillRow(row, data || {});
        document.getElementById(listId).appendChild(row);

        row.querySelectorAll('input[data-field$="icon"]').forEach(updateIconPreview);
        showSavedImage(row);
        renumber(listId);
        return row;
    }

    function updateIconPreview(input) {
        const wrap = input.closest('.sp-icon-input-wrap');
        if (!wrap) return;
        wrap.querySelector('.icon-preview').className = 'icon-preview ' + input.value.trim();
    }

    function showSavedImage(row) {
        const hidden = row.querySelector('input[data-field="card_image"]');
        const img = row.querySelector('.hp-img-preview');
        if (hidden && img && hidden.value) {
            img.src = ASSET_BASE + hidden.value.replace(/^\/+/, '');
            img.style.display = 'block';
        }
    }

    function renumber(listId) {
        document.querySelectorAll('#' + listId + ' > .sp-item').forEach(function (row, i) {
            row.querySelector('.sp-item-no').textContent = i + 1;
        });
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const row = btn.closest('.sp-item');
        const list = row.parentElement;
        const act = btn.dataset.action;

        if (act === 'remove') row.remove();
        if (act === 'up' && row.previousElementSibling) list.insertBefore(row, row.previousElementSibling);
        if (act === 'down' && row.nextElementSibling) list.insertBefore(row.nextElementSibling, row);

        renumber(list.id);
    });

    document.addEventListener('input', function (e) {
        if (e.target.matches('input[data-field$="icon"]')) updateIconPreview(e.target);
    });

    document.addEventListener('change', function (e) {
        if (!e.target.matches('[data-image-input]')) return;
        const img = e.target.closest('.sp-field').querySelector('.hp-img-preview');
        const file = e.target.files[0];
        if (file && img) {
            img.src = URL.createObjectURL(file);
            img.style.display = 'block';
        }
    });

    // tabs
    document.getElementById('hpTabs').addEventListener('click', function (e) {
        const btn = e.target.closest('.hp-tab-btn');
        if (!btn) return;
        document.querySelectorAll('.hp-tab-btn').forEach(b => b.classList.toggle('active', b === btn));
        document.querySelectorAll('.hp-tab').forEach(t => t.classList.toggle('active', t.dataset.tab === btn.dataset.tab));
        try { sessionStorage.setItem('hpTab', btn.dataset.tab); } catch (err) {}
    });
    try {
        const saved = sessionStorage.getItem('hpTab');
        const btn = saved && document.querySelector('.hp-tab-btn[data-tab="' + saved + '"]');
        if (btn) btn.click();
    } catch (err) {}

    // build existing rows
    Object.keys(initial).forEach(function (listId) {
        const cfg = initial[listId];
        Object.values(cfg.data || {}).forEach(function (row) { mount(listId, cfg.tpl, row, cfg.prefix); });
    });

    document.getElementById('homeForm').addEventListener('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    });
</script>