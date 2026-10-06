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
            color: var(--sp-text-primary);
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
            color: var(--sp-text-primary);
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

        .sp-input:hover:not(:focus),
        .sp-textarea:hover:not(:focus),
        .sp-select:hover:not(:focus) {
            border-color: var(--sp-border-hover);
        }

        .sp-icon-input-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sp-icon-preview {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: var(--sp-radius-md);
            background: var(--sp-accent-light);
            border: 1px solid var(--sp-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--sp-accent);
            font-size: 16px;
        }

        /* Image upload */
        .sp-image-row {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .sp-image-current {
            width: 140px;
            height: 96px;
            object-fit: cover;
            border-radius: var(--sp-radius-md);
            border: 1px solid var(--sp-border);
            display: none;
        }

        .sp-image-current.show {
            display: block;
        }

        .sp-image-ctrl {
            flex: 1;
            min-width: 220px;
        }

        .sp-check {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--sp-text-secondary);
            cursor: pointer;
            margin-top: 8px;
        }

        .sp-check input {
            width: 15px;
            height: 15px;
            accent-color: var(--sp-accent);
            cursor: pointer;
        }

        /* Repeater items */
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
            color: var(--sp-text-primary);
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
            padding: 12px;
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

        .sp-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: var(--sp-radius-md);
            font-size: 13.5px;
            font-weight: 580;
            font-family: var(--sp-font);
            cursor: pointer;
            line-height: 1.4;
            transition: background .15s;
            white-space: nowrap;
            background: var(--sp-accent);
            color: #fff;
            border: 1px solid transparent;
        }

        .sp-btn-primary:hover:not(:disabled) {
            background: var(--sp-accent-hover);
        }

        .sp-btn-primary:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .sp-page {
                padding: 16px;
            }
        }
    </style>

    @php
        $statsData = old('stats', $stats->map(fn($s) => [
            'value' => $s->value,
            'label' => $s->label,
            'color' => $s->color,
            'status' => $s->status,
        ])->values()->all());

        $groupsData = old('groups', $groups->map(fn($g) => [
            'title' => $g->title,
            'subtitle' => $g->subtitle,
            'icon' => $g->icon,
            'color' => $g->color,
            'footer_icon' => $g->footer_icon,
            'footer_label' => $g->footer_label,
            'footer_value' => $g->footer_value,
            'items' => $g->items->pluck('title')->implode("\n"),
            'status' => $g->status,
        ])->values()->all());

        $commitmentsData = old('commitments', $commitments->map(fn($c) => [
            'title' => $c->title,
            'description' => $c->description,
            'icon' => $c->icon,
            'color' => $c->color,
            'status' => $c->status,
        ])->values()->all());
    @endphp

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Manage About Page</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>About Page</span>
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
                <option value="fa-solid fa-microchip">
                <option value="fa-solid fa-display">
                <option value="fa-solid fa-battery-half">
                <option value="fa-solid fa-hand-holding-heart">
                <option value="fa-solid fa-boxes-packing">
                <option value="fa-solid fa-headset">
                <option value="fa-solid fa-shield-halved">
                <option value="fa-solid fa-gauge-high">
                <option value="fa-solid fa-eye">
                <option value="fa-solid fa-bolt">
                <option value="fa-solid fa-truck">
                <option value="fa-solid fa-star">
            </datalist>

            <form id="aboutForm" method="POST" action="{{ route('admin.about-page.update') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- HERO -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Hero Section</h5>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-field">
                            <label class="sp-label">Badge</label>
                            <input type="text" name="hero_badge" class="sp-input"
                                value="{{ old('hero_badge', $about->hero_badge) }}" placeholder="Our Mission">
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Title</label>
                            <input type="text" name="hero_title" class="sp-input"
                                value="{{ old('hero_title', $about->hero_title) }}">
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea name="hero_description" class="sp-textarea"
                                rows="3">{{ old('hero_description', $about->hero_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- WHO WE ARE -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Who We Are</h5>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Badge</label>
                                <input type="text" name="who_badge" class="sp-input"
                                    value="{{ old('who_badge', $about->who_badge) }}" placeholder="Who We Are">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Title</label>
                                <input type="text" name="who_title" class="sp-input"
                                    value="{{ old('who_title', $about->who_title) }}">
                            </div>
                        </div>

                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea name="who_description" class="sp-textarea"
                                rows="7">{{ old('who_description', $about->who_description) }}</textarea>
                            <div class="sp-hint">Separate paragraphs with a blank line.</div>
                        </div>

                        <div class="sp-field">
                            <label class="sp-label">Image</label>
                            <div class="sp-image-row">
                                <img id="whoImagePreview"
                                    class="sp-image-current {{ $about->who_image_url ? 'show' : '' }}"
                                    src="{{ $about->who_image_url }}" alt="Current image">
                                <div class="sp-image-ctrl">
                                    <input type="file" name="who_image" id="whoImageInput" class="sp-input"
                                        style="padding:6px 10px;height:auto" accept="image/*">
                                    <div class="sp-hint">JPG, PNG or WebP, up to 4 MB.</div>
                                    @if($about->who_image)
                                        <label class="sp-check">
                                            <input type="checkbox" name="remove_who_image" value="1"> Remove current image
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STATS -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Stats</h5>
                        <p>Small number cards under the Who We Are text (e.g. 20+ Diagnostic Checkpoints).</p>
                    </div>
                    <div class="sp-card-body">
                        <div id="list-stats"></div>
                        <button type="button" class="sp-add-btn" onclick="mountRow('stats', {color:'blue', status:1})">
                            <i class="fa fa-plus"></i> Add Stat
                        </button>
                    </div>
                </div>

                <!-- TESTING SECTION -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Testing Section</h5>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-field">
                            <label class="sp-label">Badge</label>
                            <input type="text" name="testing_badge" class="sp-input"
                                value="{{ old('testing_badge', $about->testing_badge) }}"
                                placeholder="Engineering Rigor">
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Title</label>
                            <input type="text" name="testing_title" class="sp-input"
                                value="{{ old('testing_title', $about->testing_title) }}">
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea name="testing_description" class="sp-textarea"
                                rows="3">{{ old('testing_description', $about->testing_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- TEST GROUPS -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Test Groups</h5>
                        <p>Cards such as Core Computing or Display &amp; Optics. The "x/x Checked" badge is calculated
                            from the checklist.</p>
                    </div>
                    <div class="sp-card-body">
                        <div id="list-groups"></div>
                        <button type="button" class="sp-add-btn"
                            onclick="mountRow('groups', {icon:'fa-solid fa-microchip', color:'blue', status:1})">
                            <i class="fa fa-plus"></i> Add Test Group
                        </button>
                    </div>
                </div>

                <!-- BANNER -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Quality Banner</h5>
                        <p>Dark banner at the bottom of the testing section. Leave the title empty to hide it.</p>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-field">
                            <label class="sp-label">Title</label>
                            <input type="text" name="banner_title" class="sp-input"
                                value="{{ old('banner_title', $about->banner_title) }}">
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Text</label>
                            <textarea name="banner_text" class="sp-textarea"
                                rows="2">{{ old('banner_text', $about->banner_text) }}</textarea>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Button Text</label>
                                <input type="text" name="banner_button_text" class="sp-input"
                                    value="{{ old('banner_button_text', $about->banner_button_text) }}"
                                    placeholder="Shop Tested Tech">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Button URL</label>
                                <input type="text" name="banner_button_url" class="sp-input"
                                    value="{{ old('banner_button_url', $about->banner_button_url) }}"
                                    placeholder="Leave empty to use the Shop page">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COMMITMENTS -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Our Commitments</h5>
                        <p>Three cards at the bottom of the page (No False Claims, Secure Packaging…).</p>
                    </div>
                    <div class="sp-card-body">
                        <div id="list-commitments"></div>
                        <button type="button" class="sp-add-btn"
                            onclick="mountRow('commitments', {icon:'fa-solid fa-shield-halved', color:'blue', status:1})">
                            <i class="fa fa-plus"></i> Add Commitment
                        </button>
                    </div>
                </div>

                <div class="sp-action-bar">
                    <button type="submit" id="saveBtn" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Save About Page
                    </button>
                </div>
            </form>

            <!-- ───────── Row templates ───────── -->

            <template id="tpl-stats">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Stat</div>
                        <div class="sp-item-tools">
                            <label class="sp-check" style="margin:0"><input type="checkbox" data-field="status"
                                    name="stats[__I__][status]" value="1"> Visible</label>
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
                                <label class="sp-label">Value <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="value" name="stats[__I__][value]"
                                    required placeholder="20+">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Label <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="label" name="stats[__I__][label]"
                                    required placeholder="Diagnostic Checkpoints">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Color</label>
                                <select class="sp-select" data-field="color" name="stats[__I__][color]">
                                    @foreach($colors as $color)
                                        <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-groups">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Test Group</div>
                        <div class="sp-item-tools">
                            <label class="sp-check" style="margin:0"><input type="checkbox" data-field="status"
                                    name="groups[__I__][status]" value="1"> Visible</label>
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
                                <input type="text" class="sp-input" data-field="title" name="groups[__I__][title]"
                                    required placeholder="Core Computing">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Subtitle</label>
                                <input type="text" class="sp-input" data-field="subtitle" name="groups[__I__][subtitle]"
                                    placeholder="Processor & Motherboard">
                            </div>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Icon (Font Awesome class)</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" data-field="icon" name="groups[__I__][icon]"
                                        list="iconList">
                                </div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Color</label>
                                <select class="sp-select" data-field="color" name="groups[__I__][color]">
                                    @foreach($colors as $color)
                                        <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Checklist items</label>
                            <textarea class="sp-textarea" rows="5" data-field="items" name="groups[__I__][items]"
                                placeholder="One item per line"></textarea>
                            <div class="sp-hint">One item per line.</div>
                        </div>
                        <div class="sp-row-3">
                            <div class="sp-field">
                                <label class="sp-label">Footer Icon</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" data-field="footer_icon"
                                        name="groups[__I__][footer_icon]" list="iconList">
                                </div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Footer Label</label>
                                <input type="text" class="sp-input" data-field="footer_label"
                                    name="groups[__I__][footer_label]" placeholder="Peak Performance">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Footer Value</label>
                                <input type="text" class="sp-input" data-field="footer_value"
                                    name="groups[__I__][footer_value]" placeholder="Passed 100%">
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template id="tpl-commitments">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Commitment</div>
                        <div class="sp-item-tools">
                            <label class="sp-check" style="margin:0"><input type="checkbox" data-field="status"
                                    name="commitments[__I__][status]" value="1"> Visible</label>
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
                                <label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="commitments[__I__][title]"
                                    required placeholder="No False Claims">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Icon (Font Awesome class)</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" data-field="icon"
                                        name="commitments[__I__][icon]" list="iconList">
                                </div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Color</label>
                                <select class="sp-select" data-field="color" name="commitments[__I__][color]">
                                    @foreach($colors as $color)
                                        <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea class="sp-textarea" rows="2" data-field="description"
                                name="commitments[__I__][description]"></textarea>
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    const counters = { stats: 0, groups: 0, commitments: 0 };

    const initialData = {
        stats: Object.values(@json($statsData)),
        groups: Object.values(@json($groupsData)),
        commitments: Object.values(@json($commitmentsData))
    };

    function mountRow(key, data) {
        data = data || {};
        const idx = counters[key]++;
        const html = document.getElementById('tpl-' + key).innerHTML.replaceAll('__I__', idx).trim();

        const holder = document.createElement('div');
        holder.innerHTML = html;
        const row = holder.firstElementChild;

        // Fill values through the DOM so nothing needs HTML-escaping
        Object.keys(data).forEach(function (field) {
            const el = row.querySelector('[data-field="' + field + '"]');
            if (!el) return;
            if (el.type === 'checkbox') {
                el.checked = !!Number(data[field]) || data[field] === true || data[field] === '1';
            } else {
                el.value = data[field] === null ? '' : data[field];
            }
        });

        document.getElementById('list-' + key).appendChild(row);
        row.querySelectorAll('input[data-field="icon"], input[data-field="footer_icon"]').forEach(updateIconPreview);
        renumberAll();
    }

    function updateIconPreview(input) {
        const preview = input.closest('.sp-icon-input-wrap').querySelector('.icon-preview');
        preview.className = 'icon-preview ' + input.value.trim();
    }

    function renumberAll() {
        Object.keys(counters).forEach(function (key) {
            document.querySelectorAll('#list-' + key + ' > .sp-item').forEach(function (row, i) {
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

    $(document).on('input', 'input[data-field="icon"], input[data-field="footer_icon"]', function () {
        updateIconPreview(this);
    });

    // Build existing rows
    Object.keys(initialData).forEach(function (key) {
        initialData[key].forEach(function (row) { mountRow(key, row); });
    });

    // Image preview
    document.getElementById('whoImageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById('whoImagePreview');
            img.src = e.target.result;
            img.classList.add('show');
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('aboutForm').addEventListener('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    });
</script>