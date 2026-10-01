@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --green: #007a5e;
            --green-bg: #e3f1ec;
            --red: #b22222;
            --red-bg: #fce8e8;
            --amber: #92600a;
            --amber-bg: #fdf3e1;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .import-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
        .import-page * { box-sizing: border-box; }

        /* Header */
        .import-page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .import-page-header h1 { font-size: 20px; font-weight: 650; margin: 0; }
        .crumb { font-size: 12.5px; color: var(--text-hint); margin-top: 3px; }
        .crumb a { color: var(--accent); text-decoration: none; }
        .crumb a:hover { text-decoration: underline; }
        .crumb span { margin: 0 5px; }

        /* Buttons */
        .btn-primary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff !important; border: none; border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; box-shadow: 0 1px 3px rgba(48, 61, 137, .25); }
        .btn-primary-dash:hover:not(:disabled) { background: #252f70; }
        .btn-primary-dash:disabled { opacity: .65; cursor: not-allowed; }
        .btn-secondary-dash { display: inline-flex; align-items: center; gap: 6px; background: var(--surface); color: var(--text-primary) !important; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 18px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none !important; font-family: var(--font); transition: background .15s; }
        .btn-secondary-dash:hover { background: var(--bg); }

        /* Alerts */
        .dash-alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--radius-md); font-size: 13px; margin-bottom: 16px; border: 1px solid transparent; }
        .dash-alert i { margin-top: 2px; }
        .dash-alert.success { background: var(--green-bg); color: var(--green); border-color: #bfe0d3; }
        .dash-alert.error { background: var(--red-bg); color: var(--red); border-color: #f3c6c6; }

        /* Layout */
        .import-layout { display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start; }
        @media(max-width:1000px) { .import-layout { grid-template-columns: 1fr; } }

        /* Cards */
        .section-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 16px; }
        .section-card:last-child { margin-bottom: 0; }
        .section-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: #fafafa; display: flex; align-items: center; gap: 8px; }
        .section-card-header h5 { font-size: 13px; font-weight: 650; margin: 0; letter-spacing: .01em; }
        .section-card-header i { color: var(--accent); }
        .section-card-body { padding: 20px; }
        .card-desc { font-size: 13px; color: var(--text-secondary); margin: 0 0 14px; line-height: 1.5; }

        /* Steps */
        .steps { list-style: none; margin: 0; padding: 0; counter-reset: step; }
        .steps li { position: relative; padding: 0 0 16px 38px; font-size: 13.5px; color: var(--text-primary); line-height: 1.5; counter-increment: step; }
        .steps li:last-child { padding-bottom: 0; }
        .steps li::before { content: counter(step); position: absolute; left: 0; top: -1px; width: 26px; height: 26px; border-radius: 50%; background: var(--accent-light); color: var(--accent); font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .steps li::after { content: ''; position: absolute; left: 12.5px; top: 28px; bottom: 2px; width: 1px; background: var(--border); }
        .steps li:last-child::after { display: none; }
        .steps small { display: block; font-size: 11.5px; color: var(--text-hint); margin-top: 2px; }

        /* Column reference table */
        .col-table { width: 100%; border-collapse: collapse; font-size: 12.5px; }
        .col-table th { text-align: left; font-size: 11px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: .03em; padding: 8px 10px; background: #fafafa; border-bottom: 1px solid var(--border); }
        .col-table td { padding: 8px 10px; border-bottom: 1px solid var(--bg); color: var(--text-primary); vertical-align: top; }
        .col-table tr:last-child td { border-bottom: none; }
        .col-table code { background: var(--bg); padding: 1px 6px; border-radius: 4px; font-size: 12px; color: var(--accent); }
        .col-table .req { color: var(--red); font-weight: 600; }
        .table-wrap { overflow-x: auto; border: 1px solid var(--border); border-radius: var(--radius-sm); }

        /* Note box */
        .note-box { display: flex; gap: 10px; background: var(--amber-bg); color: var(--amber); border-radius: var(--radius-sm); padding: 10px 12px; font-size: 12px; line-height: 1.5; margin-top: 14px; }
        .note-box i { margin-top: 2px; }

        /* Upload areas */
        .file-upload-area { border: 2px dashed var(--border); border-radius: var(--radius-md); padding: 24px 16px; text-align: center; cursor: pointer; transition: border-color .15s, background .15s; position: relative; }
        .file-upload-area:hover, .file-upload-area.has-file { border-color: var(--accent); background: var(--accent-light); }
        .file-upload-area input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .file-upload-area .upload-icon { font-size: 26px; color: var(--text-hint); margin-bottom: 8px; }
        .file-upload-area.has-file .upload-icon { color: var(--accent); }
        .file-upload-area p { font-size: 13px; color: var(--text-secondary); margin: 0; word-break: break-all; }
        .file-upload-area small { font-size: 11.5px; color: var(--text-hint); }
        .field-error { font-size: 11.5px; color: var(--red); margin-top: 6px; }

        .card-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 14px; }

        /* Action bar */
        .action-bar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); padding: 14px 20px; display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 20px; }

        @media(max-width:768px) { .import-page { padding: 16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="import-page">

            <!-- Page header -->
            <div class="import-page-header">
                <div>
                    <h1>Bulk Import Categories</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.categories.index') }}">Categories</a>
                        <span>›</span>
                        Import
                    </div>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary-dash">
                    <i class="fa fa-arrow-left"></i> Back to Categories
                </a>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="dash-alert success">
                    <i class="fa fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="dash-alert error">
                    <i class="fa fa-exclamation-circle"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="import-layout">

                <!-- ── LEFT column: instructions + format ─────────── -->
                <div>

                    <div class="section-card">
                        <div class="section-card-header">
                            <i class="fa fa-info-circle"></i>
                            <h5>How it works</h5>
                        </div>
                        <div class="section-card-body">
                            <ol class="steps">
                                <li>Download the sample file
                                    <small>Use the same column format.</small>
                                </li>
                                <li>Prepare your category images and put them in a ZIP
                                    <small>File names must match the <code>image_name</code> column.</small>
                                </li>
                                <li>Upload the Images ZIP</li>
                                <li>Download the Parent Category Reference file
                                    <small>Use the exact parent names from it for sub categories.</small>
                                </li>
                                <li>Fill in the sheet using the sample format</li>
                                <li>Import the Excel / CSV file</li>
                            </ol>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-card-header">
                            <i class="fa fa-table"></i>
                            <h5>Column Reference</h5>
                        </div>
                        <div class="section-card-body">
                            <div class="table-wrap">
                                <table class="col-table">
                                    <thead>
                                        <tr>
                                            <th>Column</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>name</code> <span class="req">*</span></td>
                                            <td>Category name</td>
                                        </tr>
                                        <tr>
                                            <td><code>sub_title</code></td>
                                            <td>Short description shown on the category card</td>
                                        </tr>
                                        <tr>
                                            <td><code>image_name</code></td>
                                            <td>File name from the ZIP, e.g. <code>laptops.jpg</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>parent_category</code></td>
                                            <td>Leave empty for a top-level category, otherwise the exact parent name</td>
                                        </tr>
                                        <tr>
                                            <td><code>meta_title</code>, <code>meta_description</code></td>
                                            <td>SEO fields</td>
                                        </tr>
                                        <tr>
                                            <td><code>is_popular</code>, <code>is_featured</code>, <code>status</code></td>
                                            <td><code>1</code> = Yes / Active, <code>0</code> = No / Inactive</td>
                                        </tr>
                                        <tr>
                                            <td><code>sort_order</code></td>
                                            <td>Lower numbers appear first</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="note-box">
                                <i class="fa fa-lightbulb-o"></i>
                                <div>Import parent categories first, then sub categories, so the parent names exist when the sub categories are read.</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ── RIGHT column: downloads + uploads ──────────── -->
                <div>

                    <!-- Downloads -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <i class="fa fa-download"></i>
                            <h5>Step 1 · Download Files</h5>
                        </div>
                        <div class="section-card-body">
                            <p class="card-desc">Get the sample sheet and the list of existing parent categories.</p>
                            <div class="card-actions" style="margin-top:0">
                                <a href="{{ route('admin.categories.import.sample') }}" class="btn-primary-dash">
                                    <i class="fa fa-file-text-o"></i> Sample File
                                </a>
                                <a href="{{ route('admin.categories.parent.reference') }}" class="btn-secondary-dash">
                                    <i class="fa fa-list"></i> Parent Reference
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Upload images ZIP -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <i class="fa fa-file-archive-o"></i>
                            <h5>Step 2 · Upload Images ZIP</h5>
                        </div>
                        <div class="section-card-body">
                            <form action="{{ route('admin.categories.images.upload') }}" method="POST"
                                enctype="multipart/form-data" class="js-upload-form">
                                @csrf

                                <div class="file-upload-area">
                                    <input type="file" name="zip_file" accept=".zip" required>
                                    <div class="upload-icon"><i class="fa fa-file-archive-o"></i></div>
                                    <p class="js-file-label">Click or drag a ZIP file here</p>
                                    <small>ZIP with images, e.g. laptops.jpg, mobile-phones.jpg</small>
                                </div>
                                @error('zip_file') <div class="field-error">{{ $message }}</div> @enderror

                                <div class="card-actions">
                                    <button type="submit" class="btn-primary-dash js-submit-btn" data-loading="Uploading…">
                                        <i class="fa fa-upload"></i> Upload Images ZIP
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Import sheet -->
                    <div class="section-card">
                        <div class="section-card-header">
                            <i class="fa fa-file-excel-o"></i>
                            <h5>Step 3 · Import Categories</h5>
                        </div>
                        <div class="section-card-body">
                            <form action="{{ route('admin.categories.import.store') }}" method="POST"
                                enctype="multipart/form-data" class="js-upload-form">
                                @csrf

                                <div class="file-upload-area">
                                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
                                    <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                    <p class="js-file-label">Click or drag your sheet here</p>
                                    <small>XLSX, XLS or CSV</small>
                                </div>
                                @error('file') <div class="field-error">{{ $message }}</div> @enderror

                                <div class="card-actions">
                                    <button type="submit" class="btn-primary-dash js-submit-btn" data-loading="Importing…">
                                        <i class="fa fa-check"></i> Import Categories
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Action bar -->
            <div class="action-bar">
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary-dash">
                    Back To Categories
                </a>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    document.querySelectorAll('.js-upload-form').forEach(function (form) {
        const area  = form.querySelector('.file-upload-area');
        const input = form.querySelector('input[type=file]');
        const label = form.querySelector('.js-file-label');
        const btn   = form.querySelector('.js-submit-btn');

        // Show the chosen file name
        input.addEventListener('change', function () {
            if (this.files.length) {
                label.textContent = this.files[0].name;
                area.classList.add('has-file');
            }
        });

        // Prevent double submit
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> ' + btn.dataset.loading;
        });
    });
</script>