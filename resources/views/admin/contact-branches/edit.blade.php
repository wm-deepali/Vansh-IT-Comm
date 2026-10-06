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
        --sp-radius-sm: 6px;
        --sp-radius-md: 8px;
        --sp-radius-lg: 12px;
        --sp-shadow-card: 0 1px 0 rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07);
        --sp-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .sp-page { background: var(--sp-bg); padding: 24px 28px; min-height: 100vh; font-family: var(--sp-font); color: var(--sp-text-primary); font-size: 14px; }
    .sp-page * { box-sizing: border-box; }

    .sp-page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
    .sp-page-title { font-size: 20px; font-weight: 660; color: var(--sp-text-primary); margin: 0 0 4px; letter-spacing: -.2px; }
    .sp-crumb { font-size: 12.5px; color: var(--sp-text-hint); display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .sp-crumb a { color: var(--sp-accent); text-decoration: none; }
    .sp-crumb a:hover { text-decoration: underline; }

    .sp-create-layout { display: grid; grid-template-columns: 1fr 260px; gap: 20px; align-items: start; }
    @media (max-width: 900px) { .sp-create-layout { grid-template-columns: 1fr; } }

    .sp-card { background: var(--sp-surface); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); border: 1px solid var(--sp-border); overflow: hidden; margin-bottom: 16px; }
    .sp-card:last-child { margin-bottom: 0; }
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; }
    .sp-card-body { padding: 20px 24px; }
    .sp-card-body-sm { padding: 14px 20px; }

    .sp-field { margin-bottom: 18px; }
    .sp-field:last-child { margin-bottom: 0; }
    .sp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 600px) { .sp-row { grid-template-columns: 1fr; } }

    .sp-label { display: block; font-size: 12px; font-weight: 620; color: var(--sp-text-secondary); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 6px; }
    .sp-req { color: var(--sp-red); margin-left: 2px; }
    .sp-hint { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; }

    .sp-input, .sp-textarea { width: 100%; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 12px; font-size: 13.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--sp-font); }
    .sp-input { height: 38px; }
    .sp-textarea { padding: 10px 12px; resize: vertical; min-height: 80px; line-height: 1.6; }
    .sp-input:focus, .sp-textarea:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-input:hover:not(:focus), .sp-textarea:hover:not(:focus) { border-color: var(--sp-border-hover); }

    .sp-icon-input-wrap { display: flex; align-items: center; gap: 8px; }
    .sp-icon-preview { width: 38px; height: 38px; flex-shrink: 0; border-radius: var(--sp-radius-md); background: var(--sp-accent-light); border: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: center; color: var(--sp-accent); font-size: 16px; }

    .sp-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--sp-bg); }
    .sp-toggle-row:first-child { padding-top: 0; }
    .sp-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sp-toggle-label { font-size: 13px; font-weight: 500; color: var(--sp-text-primary); }
    .sp-toggle-sub { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 1px; }

    .sp-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
    .sp-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .sp-switch-track { position: absolute; inset: 0; background: var(--sp-border); border-radius: 22px; cursor: pointer; transition: background .2s; }
    .sp-switch-track::after { content: ''; position: absolute; left: 3px; top: 3px; width: 16px; height: 16px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .sp-switch input:checked + .sp-switch-track { background: var(--sp-accent); }
    .sp-switch input:checked + .sp-switch-track::after { transform: translateX(16px); }

    .sp-action-bar { background: var(--sp-surface); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .sp-btn-primary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-accent); color: #fff; border: 1px solid transparent; border-radius: var(--sp-radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 580; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: background .15s; white-space: nowrap; }
    .sp-btn-primary:hover:not(:disabled) { background: var(--sp-accent-hover); color: #fff; }
    .sp-btn-primary:disabled { opacity: .65; cursor: not-allowed; }
    .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 8px 16px; font-size: 13.5px; font-weight: 540; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: background .15s, border-color .15s; white-space: nowrap; }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); color: var(--sp-text-primary); }

    @media (max-width: 768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <!-- Page header -->
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Edit Branch</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.contact-branches.index') }}">Contact Branches</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Edit Branch</span>
                    </div>
                </div>
            </div>

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
                <option value="fa-solid fa-store">
                <option value="fa-solid fa-building">
                <option value="fa-solid fa-warehouse">
                <option value="fa-solid fa-screwdriver-wrench">
                <option value="fa-solid fa-laptop">
                <option value="fa-solid fa-mobile-screen">
                <option value="fa-solid fa-headset">
                <option value="fa-solid fa-truck">
                <option value="fa-solid fa-location-dot">
            </datalist>

            <form id="branchForm" method="POST" action="{{ route('admin.contact-branches.update', $branch->id) }}">
                @csrf
                @method('PUT')

                <div class="sp-create-layout">

                    <!-- LEFT — branch details -->
                    <div>
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Branch Details</h5></div>
                            <div class="sp-card-body">

                                <div class="sp-row">
                                    <div class="sp-field">
                                        <label class="sp-label">Branch Name <span class="sp-req">*</span></label>
                                        <input type="text" name="title" class="sp-input" value="{{ old('title', $branch->title) }}" required>
                                    </div>
                                    <div class="sp-field">
                                        <label class="sp-label">Subtitle</label>
                                        <input type="text" name="subtitle" class="sp-input" value="{{ old('subtitle', $branch->subtitle) }}" placeholder="e.g. Fast Diagnostics & Soldering Lab">
                                    </div>
                                </div>

                                <div class="sp-field">
                                    <label class="sp-label">Address</label>
                                    <textarea name="address" class="sp-textarea" rows="3"
                                              placeholder="Street, city, state, ZIP…">{{ old('address', $branch->address) }}</textarea>
                                </div>

                                <div class="sp-row">
                                    <div class="sp-field">
                                        <label class="sp-label">Phone</label>
                                        <input type="text" name="phone" class="sp-input" value="{{ old('phone', $branch->phone) }}">
                                    </div>
                                    <div class="sp-field">
                                        <label class="sp-label">Email</label>
                                        <input type="email" name="email" class="sp-input" value="{{ old('email', $branch->email) }}">
                                    </div>
                                </div>

                                <div class="sp-field" style="margin-bottom:0">
                                    <label class="sp-label">Working Hours</label>
                                    <input type="text" name="working_hours" class="sp-input"
                                           value="{{ old('working_hours', $branch->working_hours) }}" placeholder="Mon – Sat: 10:00 AM – 8:30 PM">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT — sidebar -->
                    <div>

                        <!-- Icon -->
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Branch Icon</h5></div>
                            <div class="sp-card-body">
                                <label class="sp-label">Font Awesome class</label>
                                <div class="sp-icon-input-wrap">
                                    <div class="sp-icon-preview">
                                        <i id="iconPreview" class="{{ old('icon', $branch->icon) ?: 'fa-solid fa-store' }}"></i>
                                    </div>
                                    <input type="text" name="icon" id="iconInput" class="sp-input" list="iconList"
                                           value="{{ old('icon', $branch->icon) ?: 'fa-solid fa-store' }}">
                                </div>
                                <div class="sp-hint">e.g. fa-solid fa-store</div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Settings</h5></div>
                            <div class="sp-card-body-sm">
                                <div class="sp-toggle-row">
                                    <div>
                                        <div class="sp-toggle-label">Status</div>
                                        <div class="sp-toggle-sub">Branch is visible publicly</div>
                                    </div>
                                    <label class="sp-switch">
                                        <input type="hidden" name="status" value="0" {{ $branch->status ? 'disabled' : '' }}>
                                        <input type="checkbox" id="status" value="1"
                                               onchange="this.previousElementSibling.disabled = this.checked"
                                               {{ $branch->status ? 'checked' : '' }}>
                                        <span class="sp-switch-track"></span>
                                    </label>
                                </div>
                                <div class="sp-field" style="margin-top:14px">
                                    <label class="sp-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="sp-input" min="0"
                                           value="{{ old('sort_order', $branch->sort_order) }}">
                                    <div class="sp-hint">Lower numbers appear first</div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Action bar -->
                <div class="sp-action-bar">
                    <a href="{{ route('admin.contact-branches.index') }}" class="sp-btn-secondary">Cancel</a>
                    <button type="submit" id="saveBtn" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Update Branch
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.getElementById('iconInput').addEventListener('input', function () {
    document.getElementById('iconPreview').className = this.value.trim() || 'fa-solid fa-store';
});

document.getElementById('branchForm').addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
});
</script>