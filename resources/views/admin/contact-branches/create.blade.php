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
    .sp-card-header { padding: 13px 20px; border-bottom: 1px solid var(--sp-border); background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .sp-card-header h5 { font-size: 13px; font-weight: 650; color: var(--sp-text-primary); margin: 0; display: flex; align-items: center; gap: 8px; }
    .sp-card-body { padding: 20px 24px; }
    .sp-card-body-sm { padding: 14px 20px; }

    .sp-branch-tag { display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; background: var(--sp-accent-light); color: var(--sp-accent); font-size: 11px; font-weight: 700; flex-shrink: 0; }

    .sp-remove-btn { display: inline-flex; align-items: center; gap: 5px; background: none; border: none; color: var(--sp-text-hint); font-size: 12px; cursor: pointer; padding: 4px 8px; border-radius: var(--sp-radius-sm); font-family: var(--sp-font); transition: all .15s; }
    .sp-remove-btn:hover { background: var(--sp-red-bg); color: var(--sp-red); }

    .sp-field { margin-bottom: 18px; }
    .sp-field:last-child { margin-bottom: 0; }
    .sp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 600px) { .sp-row { grid-template-columns: 1fr; } }

    .sp-label { display: block; font-size: 12px; font-weight: 620; color: var(--sp-text-secondary); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 6px; }
    .sp-req { color: var(--sp-red); margin-left: 2px; }
    .sp-hint { font-size: 11.5px; color: var(--sp-text-hint); margin-top: 5px; }

    .sp-input, .sp-textarea, .sp-select { width: 100%; border: 1px solid var(--sp-border); border-radius: var(--sp-radius-md); padding: 0 12px; font-size: 13.5px; color: var(--sp-text-primary); background: var(--sp-surface); outline: none; transition: border-color .15s, box-shadow .15s; font-family: var(--sp-font); }
    .sp-input, .sp-select { height: 38px; }
    .sp-textarea { padding: 10px 12px; resize: vertical; min-height: 80px; line-height: 1.6; }
    .sp-input:focus, .sp-textarea:focus, .sp-select:focus { border-color: var(--sp-accent); box-shadow: 0 0 0 3px rgba(48,61,137,.10); }
    .sp-input:hover:not(:focus), .sp-textarea:hover:not(:focus), .sp-select:hover:not(:focus) { border-color: var(--sp-border-hover); }

    .sp-icon-input-wrap { display: flex; align-items: center; gap: 8px; }
    .sp-icon-preview { width: 38px; height: 38px; flex-shrink: 0; border-radius: var(--sp-radius-md); background: var(--sp-accent-light); border: 1px solid var(--sp-border); display: flex; align-items: center; justify-content: center; color: var(--sp-accent); font-size: 16px; }

    .sp-add-btn { width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; border: 2px dashed var(--sp-border); border-radius: var(--sp-radius-lg); background: transparent; color: var(--sp-text-secondary); font-size: 13px; font-weight: 600; padding: 14px; cursor: pointer; font-family: var(--sp-font); transition: all .15s; margin-top: 12px; margin-bottom: 20px; }
    .sp-add-btn:hover { border-color: var(--sp-accent); background: var(--sp-accent-light); color: var(--sp-accent); }

    .sp-info-row { display: flex; align-items: flex-start; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--sp-bg); font-size: 12.5px; color: var(--sp-text-secondary); line-height: 1.6; }
    .sp-info-row:first-child { padding-top: 0; }
    .sp-info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .sp-info-row i { color: var(--sp-accent); margin-top: 2px; flex-shrink: 0; }
    .sp-info-row strong { display: block; color: var(--sp-text-primary); font-size: 12.5px; margin-bottom: 1px; }

    .sp-action-bar { background: var(--sp-surface); border: 1px solid var(--sp-border); border-radius: var(--sp-radius-lg); box-shadow: var(--sp-shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .sp-btn-primary, .sp-btn-secondary { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--sp-radius-md); font-size: 13.5px; font-weight: 580; font-family: var(--sp-font); cursor: pointer; text-decoration: none; line-height: 1.4; transition: background .15s; white-space: nowrap; }
    .sp-btn-primary { background: var(--sp-accent); color: #fff; border: 1px solid transparent; }
    .sp-btn-primary:hover:not(:disabled) { background: var(--sp-accent-hover); color: #fff; }
    .sp-btn-primary:disabled { opacity: .65; cursor: not-allowed; }
    .sp-btn-secondary { background: var(--sp-surface); color: var(--sp-text-primary); border: 1px solid var(--sp-border); }
    .sp-btn-secondary:hover { background: var(--sp-bg); border-color: var(--sp-border-hover); }

    @media (max-width: 768px) { .sp-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">
            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Add Contact Branches</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.contact-branches.index') }}">Contact Branches</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Add Branches</span>
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

            <form id="branchForm" method="POST" action="{{ route('admin.contact-branches.store') }}">
                @csrf
                <div class="sp-create-layout">
                    <div>
                        <div id="branchWrap">
                            <div class="sp-card branch-block">
                                <div class="sp-card-header">
                                    <h5>
                                        <span class="sp-branch-tag">1</span>
                                        Branch <span class="branch-number">1</span>
                                    </h5>
                                    <button type="button" class="sp-remove-btn" style="display:none">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                </div>
                                <div class="sp-card-body">
                                    <div class="sp-row">
                                        <div class="sp-field">
                                            <label class="sp-label">Branch Name <span class="sp-req">*</span></label>
                                            <input type="text" name="title[]" class="sp-input" required>
                                        </div>
                                        <div class="sp-field">
                                            <label class="sp-label">Subtitle</label>
                                            <input type="text" name="subtitle[]" class="sp-input" placeholder="e.g. Fast Diagnostics & Soldering Lab">
                                        </div>
                                    </div>

                                    <div class="sp-row">
                                        <div class="sp-field">
                                            <label class="sp-label">Phone</label>
                                            <input type="text" name="phone[]" class="sp-input">
                                        </div>
                                        <div class="sp-field">
                                            <label class="sp-label">Email</label>
                                            <input type="email" name="email[]" class="sp-input">
                                        </div>
                                    </div>

                                    <div class="sp-field">
                                        <label class="sp-label">Address</label>
                                        <textarea name="address[]" class="sp-textarea" rows="3" placeholder="Street, city, state, ZIP…"></textarea>
                                    </div>

                                    <div class="sp-row">
                                        <div class="sp-field">
                                            <label class="sp-label">Working Hours</label>
                                            <input type="text" name="working_hours[]" class="sp-input" placeholder="Mon – Sat: 10:00 AM – 8:30 PM">
                                        </div>
                                        <div class="sp-field">
                                            <label class="sp-label">Icon (Font Awesome class)</label>
                                            <div class="sp-icon-input-wrap">
                                                <div class="sp-icon-preview"><i class="icon-preview fa-solid fa-store"></i></div>
                                                <input type="text" name="icon[]" class="sp-input branch-icon-input" list="iconList" value="fa-solid fa-store">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sp-row">
                                        <div class="sp-field">
                                            <label class="sp-label">Status</label>
                                            <select name="status[]" class="sp-select">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="sp-field">
                                            <label class="sp-label">Sort Order</label>
                                            <input type="number" name="sort_order[]" class="sp-input" min="0" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="sp-add-btn" onclick="addBranch()">
                            <i class="fa fa-plus"></i> Add Another Branch
                        </button>
                    </div>

                    <div>
                        <div class="sp-card">
                            <div class="sp-card-header"><h5>Tips</h5></div>
                            <div class="sp-card-body-sm">
                                <div class="sp-info-row">
                                    <i class="fa fa-circle-info"></i>
                                    <div>
                                        <strong>Multiple Branches</strong>
                                        Click "Add Another Branch" to add more in one go.
                                    </div>
                                </div>
                                <div class="sp-info-row">
                                    <i class="fa fa-icons"></i>
                                    <div>
                                        <strong>Icon</strong>
                                        Full Font Awesome class, e.g. <em>fa-solid fa-store</em>. Pick a suggestion or type your own.
                                    </div>
                                </div>
                                <div class="sp-info-row">
                                    <i class="fa fa-arrow-down-1-9"></i>
                                    <div>
                                        <strong>Sort Order</strong>
                                        Lower numbers appear first on the Contact page.
                                    </div>
                                </div>
                                <div class="sp-info-row">
                                    <i class="fa fa-trash"></i>
                                    <div>
                                        <strong>Remove</strong>
                                        Use the Remove button to delete a branch before saving.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sp-action-bar">
                    <a href="{{ route('admin.contact-branches.index') }}" class="sp-btn-secondary">Cancel</a>
                    <button type="submit" id="saveBtn" class="sp-btn-primary">
                        <i class="fa fa-save"></i> Save Branches
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
const DEFAULT_ICON = 'fa-solid fa-store';

function renumberBranches() {
    $('#branchWrap .branch-block').each(function (i) {
        const num = i + 1;
        $(this).find('.sp-branch-tag').text(num);
        $(this).find('.branch-number').text(num);
    });
}
function updateRemoveButtons() {
    $('.sp-remove-btn').toggle($('#branchWrap .branch-block').length > 1);
}
function addBranch() {
    const $clone = $('#branchWrap .branch-block').first().clone();
    $clone.find('input[type="text"], input[type="email"], textarea').val('');
    $clone.find('.branch-icon-input').val(DEFAULT_ICON);
    $clone.find('.icon-preview').attr('class', 'icon-preview ' + DEFAULT_ICON);
    $clone.find('select').val('1');
    $clone.find('input[type="number"]').val($('#branchWrap .branch-block').length);
    $('#branchWrap').append($clone);
    renumberBranches();
    updateRemoveButtons();
}
$(document).on('click', '.sp-remove-btn', function () {
    $(this).closest('.branch-block').remove();
    renumberBranches();
    updateRemoveButtons();
});
$(document).on('input', '.branch-icon-input', function () {
    const val = $(this).val().trim() || DEFAULT_ICON;
    $(this).closest('.sp-icon-input-wrap').find('.icon-preview').attr('class', 'icon-preview ' + val);
});
$('#branchForm').on('submit', function () {
    const btn = $('#saveBtn');
    btn.prop('disabled', true);
    btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
});
</script>