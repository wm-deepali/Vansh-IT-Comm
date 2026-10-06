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

        .svc-list {
            margin-top: 18px;
            padding-left: 14px;
            border-left: 3px solid var(--sp-accent-light);
        }

        .svc-list .sp-item {
            background: #fcfcfd;
        }

        .svc-label {
            font-size: 12px;
            font-weight: 650;
            color: var(--sp-text-secondary);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin: 18px 0 8px;
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
            background: var(--sp-accent);
            color: #fff;
            border: 1px solid transparent;
            transition: background .15s;
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
        $categoriesData = old('categories', $categories->map(fn($c) => [
            'eyebrow' => $c->eyebrow,
            'title' => $c->title,
            'status' => $c->status,
            'services' => $c->services->map(fn($s) => [
                'title' => $s->title,
                'description' => $s->description,
                'estimated_time' => $s->estimated_time,
                'icon' => $s->icon,
                'color' => $s->color,
                'status' => $s->status,
            ])->values()->all(),
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
                    <h1 class="sp-page-title">Manage Repair Page</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Repair Page</span>
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
                <option value="fa-solid fa-display">
                <option value="fa-solid fa-battery-three-quarters">
                <option value="fa-solid fa-hard-drive">
                <option value="fa-solid fa-keyboard">
                <option value="fa-solid fa-fan">
                <option value="fa-solid fa-microchip">
                <option value="fa-solid fa-mobile-screen">
                <option value="fa-solid fa-plug">
                <option value="fa-solid fa-camera">
                <option value="fa-solid fa-volume-high">
                <option value="fa-solid fa-shield">
                <option value="fa-solid fa-screwdriver-wrench">
                <option value="fa-solid fa-laptop">
            </datalist>

            <form id="repairForm" method="POST" action="{{ route('admin.repair-page.update') }}">
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
                                    value="{{ old('hero_badge', $page->hero_badge) }}"
                                    placeholder="Certified Technicians">
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
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Primary Button (scrolls to booking form)</label>
                                <input type="text" name="hero_primary_text" class="sp-input"
                                    value="{{ old('hero_primary_text', $page->hero_primary_text) }}"
                                    placeholder="Book Repair">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Secondary Button (opens Contact page)</label>
                                <input type="text" name="hero_secondary_text" class="sp-input"
                                    value="{{ old('hero_secondary_text', $page->hero_secondary_text) }}"
                                    placeholder="Call Expert">
                            </div>
                        </div>
                        <div class="sp-hint">Leave a button text empty to hide that button.</div>
                    </div>
                </div>

                <!-- CATEGORIES + SERVICES -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Service Categories</h5>
                        <p>Each category is a section on the page (e.g. Laptop Repair Services) with its own service
                            cards.</p>
                    </div>
                    <div class="sp-card-body">
                        <div id="list-categories" class="sp-list"></div>
                        <button type="button" class="sp-add-btn" onclick="mountCategory({status:1})">
                            <i class="fa fa-plus"></i> Add Category
                        </button>
                    </div>
                </div>

                <!-- BOOKING FORM -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Booking Form Section</h5>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Badge</label>
                                <input type="text" name="booking_badge" class="sp-input"
                                    value="{{ old('booking_badge', $page->booking_badge) }}"
                                    placeholder="Fast Service Request">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Title</label>
                                <input type="text" name="booking_title" class="sp-input"
                                    value="{{ old('booking_title', $page->booking_title) }}">
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea name="booking_description" class="sp-textarea"
                                rows="2">{{ old('booking_description', $page->booking_description) }}</textarea>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Note under the button</label>
                            <input type="text" name="booking_note" class="sp-input"
                                value="{{ old('booking_note', $page->booking_note) }}">
                        </div>
                    </div>
                </div>

                <!-- DROPDOWN OPTIONS -->
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h5>Booking Form Dropdown Options</h5>
                        <p>One option per line. Use <strong>Label | stored value</strong> if the saved value should
                            differ from what customers see. A dropdown with no options is hidden.</p>
                    </div>
                    <div class="sp-card-body">
                        @foreach(\App\Models\RepairOption::TYPES as $type => $label)
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
                        <i class="fa fa-save"></i> Save Repair Page
                    </button>
                </div>
            </form>

            <!-- ───────── Templates ───────── -->

            <template id="tpl-category">
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
                                <label class="sp-label">Small heading above title</label>
                                <input type="text" class="sp-input" data-field="eyebrow"
                                    name="categories[__I__][eyebrow]" placeholder="Hardware & Software Fixes">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Title <span class="sp-req">*</span></label>
                                <input type="text" class="sp-input" data-field="title" name="categories[__I__][title]"
                                    required placeholder="Laptop Repair Services">
                            </div>
                        </div>

                        <div class="svc-label">Services in this category</div>
                        <div class="sp-list svc-list"></div>
                        <button type="button" class="sp-add-btn" style="margin-top:6px"
                            onclick="mountService(this, {icon:'fa-solid fa-screwdriver-wrench', color:'blue', status:1})">
                            <i class="fa fa-plus"></i> Add Service
                        </button>
                    </div>
                </div>
            </template>

            <template id="tpl-service">
                <div class="sp-item">
                    <div class="sp-item-head">
                        <div class="sp-item-title"><span class="sp-item-no">1</span> Service</div>
                        <div class="sp-item-tools">
                            <label class="sp-check"><input type="checkbox" data-field="status"
                                    name="categories[__I__][services][__J__][status]" value="1"> Visible</label>
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
                                <input type="text" class="sp-input" data-field="title"
                                    name="categories[__I__][services][__J__][title]" required
                                    placeholder="Screen Replacement">
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Estimated Time</label>
                                <input type="text" class="sp-input" data-field="estimated_time"
                                    name="categories[__I__][services][__J__][estimated_time]" placeholder="2–4 Hours">
                            </div>
                        </div>
                        <div class="sp-field">
                            <label class="sp-label">Description</label>
                            <textarea class="sp-textarea" rows="2" data-field="description"
                                name="categories[__I__][services][__J__][description]"></textarea>
                        </div>
                        <div class="sp-row">
                            <div class="sp-field">
                                <label class="sp-label">Icon (Font Awesome class)</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview"><i class="icon-preview"></i></div>
                                    <input type="text" class="sp-input" data-field="icon"
                                        name="categories[__I__][services][__J__][icon]" list="iconList">
                                </div>
                            </div>
                            <div class="sp-field">
                                <label class="sp-label">Color</label>
                                <select class="sp-select" data-field="color"
                                    name="categories[__I__][services][__J__][color]">
                                    @foreach($colors as $color)
                                        <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                                    @endforeach
                                </select>
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
    let categoryCounter = 0;
    const initialCategories = Object.values(@json($categoriesData));

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

    function buildRow(templateId, replacements) {
        let html = document.getElementById(templateId).innerHTML;
        Object.keys(replacements).forEach(function (k) { html = html.replaceAll(k, replacements[k]); });
        const holder = document.createElement('div');
        holder.innerHTML = html.trim();
        return holder.firstElementChild;
    }

    function mountCategory(data) {
        data = data || {};
        const idx = categoryCounter++;
        const row = buildRow('tpl-category', { '__I__': idx });
        row.dataset.idx = idx;
        row.dataset.svc = 0;

        fillRow(row, data);
        document.getElementById('list-categories').appendChild(row);

        Object.values(data.services || {}).forEach(function (svc) { addService(row, svc); });
        renumberAll();
        return row;
    }

    function mountService(btn, data) {
        addService(btn.closest('.sp-item'), data);
        renumberAll();
    }

    function addService(catRow, data) {
        const j = parseInt(catRow.dataset.svc, 10);
        catRow.dataset.svc = j + 1;

        const row = buildRow('tpl-service', { '__I__': catRow.dataset.idx, '__J__': j });
        fillRow(row, data || {});
        catRow.querySelector('.svc-list').appendChild(row);
        updateIconPreview(row.querySelector('input[data-field="icon"]'));
    }

    function updateIconPreview(input) {
        if (!input) return;
        input.closest('.sp-icon-input-wrap').querySelector('.icon-preview').className =
            'icon-preview ' + input.value.trim();
    }

    function renumberAll() {
        document.querySelectorAll('.sp-list').forEach(function (list) {
            Array.from(list.children)
                .filter(function (el) { return el.classList.contains('sp-item'); })
                .forEach(function (row, i) {
                    row.querySelector(':scope > .sp-item-head .sp-item-no').textContent = i + 1;
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

    $(document).on('input', 'input[data-field="icon"]', function () { updateIconPreview(this); });

    initialCategories.forEach(function (cat) { mountCategory(cat); });

    document.getElementById('repairForm').addEventListener('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    });
</script>