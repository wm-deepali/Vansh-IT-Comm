@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4;--surface:#ffffff;--border:#e3e5e8;--border-hover:#c9cccf;
        --text-primary:#202223;--text-secondary:#6d7175;--text-hint:#8c9196;
        --accent:#303d89;--accent-hover:#252f70;--accent-light:#f0f1fc;
        --green:#007a5e;--green-bg:#e3f1ec;
        --amber:#916a00;--amber-bg:#fff5cc;
        --blue:#0069d9;--blue-bg:#e8f2ff;
        --radius-sm:8px;--radius-md:12px;
        --shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
        --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }
    .list-page{background:var(--bg);padding:24px 28px;min-height:100vh;font-family:var(--font);color:var(--text-primary);}
    .list-page *{box-sizing:border-box;}

    /* Header */
    .list-page-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;}
    .list-page-header h1{font-size:20px;font-weight:650;color:var(--text-primary);margin:0;}
    .crumb{font-size:12.5px;color:var(--text-hint);margin-top:3px;}
    .crumb a{color:var(--accent);text-decoration:none;}
    .crumb a:hover{text-decoration:underline;}
    .crumb span{margin:0 5px;}

    /* Buttons */
    .btn-secondary-dash{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--surface);color:var(--text-primary) !important;border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none !important;font-family:var(--font);transition:background .15s;white-space:nowrap;}
    .btn-secondary-dash:hover{background:var(--bg);border-color:var(--border-hover);}
    .btn-accent-dash{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:var(--accent);color:#fff !important;border:1px solid var(--accent);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;font-family:var(--font);transition:background .15s;white-space:nowrap;}
    .btn-accent-dash:hover{background:var(--accent-hover);}

    /* Layout */
    .detail-layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;}
    @media(max-width:900px){.detail-layout{grid-template-columns:1fr;}}

    /* Cards */
    .list-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden;margin-bottom:16px;}
    .list-card:last-child{margin-bottom:0;}
    .card-head{padding:13px 20px;border-bottom:1px solid var(--border);background:#fafafa;}
    .card-head h5{font-size:13px;font-weight:650;color:var(--text-primary);margin:0;}
    .card-body-pad{padding:20px 24px;}

    /* Profile row */
    .profile-row{display:flex;align-items:center;gap:14px;padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid var(--border);flex-wrap:wrap;}
    .profile-avatar{width:52px;height:52px;border-radius:50%;flex-shrink:0;background:var(--accent-light);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:var(--accent);text-transform:uppercase;}
    .profile-info{flex:1;min-width:160px;}
    .profile-name{font-size:16px;font-weight:650;color:var(--text-primary);line-height:1.3;}
    .profile-date{font-size:12.5px;color:var(--text-hint);margin-top:2px;}

    /* Info grid */
    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px 24px;margin-bottom:24px;}
    @media(max-width:600px){.info-grid{grid-template-columns:1fr;}}
    .info-label{font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);margin-bottom:5px;}
    .info-value{font-size:13.5px;color:var(--text-primary);word-break:break-word;}
    .info-value a{color:var(--accent);text-decoration:none;}
    .info-value a:hover{text-decoration:underline;}

    /* Message */
    .msg-box{background:#fafbfc;border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px 18px;font-size:13.5px;line-height:1.7;color:var(--text-primary);}

    /* Tags / pills */
    .inq-tag{display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:12px;font-weight:600;background:var(--amber-bg);color:var(--amber);border:1px solid rgba(145,106,0,.15);}
    .pill{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;white-space:nowrap;}
    .pill::before{content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0;}
    .pill-new{background:var(--blue-bg);color:var(--blue);}
    .pill-new::before{background:var(--blue);}
    .pill-read{background:var(--amber-bg);color:var(--amber);}
    .pill-read::before{background:var(--amber);}
    .pill-replied{background:var(--green-bg);color:var(--green);}
    .pill-replied::before{background:var(--green);}

    /* Sidebar */
    .side-label{display:block;font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);margin-bottom:6px;}
    .status-select{width:100%;height:38px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 12px;font-size:13.5px;font-family:var(--font);background:var(--surface);color:var(--text-primary);outline:none;margin-bottom:12px;}
    .status-select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(48,61,137,.10);}
    .side-actions{display:flex;flex-direction:column;gap:8px;}
    .side-actions .btn-secondary-dash,.side-actions .btn-accent-dash{width:100%;}

    .alert-ok{background:var(--green-bg);color:var(--green);border:1px solid rgba(0,122,94,.2);border-radius:var(--radius-sm);padding:10px 16px;font-size:13px;font-weight:500;margin-bottom:16px;}

    @media(max-width:768px){.list-page{padding:16px;}}
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <!-- Page header -->
            <div class="list-page-header">
                <div>
                    <h1>Contact Enquiry Details</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.contact-enquiries.index') }}">Contact Enquiries</a>
                        <span>›</span>
                        View Enquiry
                    </div>
                </div>

                <a href="{{ route('admin.contact-enquiries.index') }}" class="btn-secondary-dash">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

            @if(session('success'))
                <div class="alert-ok"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <div class="detail-layout">

                <!-- LEFT — enquiry details -->
                <div>
                    <div class="list-card">
                        <div class="card-head"><h5>Enquiry Details</h5></div>
                        <div class="card-body-pad">

                            <div class="profile-row">
                                <div class="profile-avatar">{{ strtoupper(substr($enquiry->name, 0, 1)) }}</div>
                                <div class="profile-info">
                                    <div class="profile-name">{{ $enquiry->name }}</div>
                                    <div class="profile-date">
                                        Submitted {{ $enquiry->created_at->format('d M Y') }} at {{ $enquiry->created_at->format('h:i A') }}
                                    </div>
                                </div>
                                <span class="pill pill-{{ $enquiry->status }}">
                                    {{ \App\Models\ContactEnquiry::STATUSES[$enquiry->status] ?? ucfirst($enquiry->status) }}
                                </span>
                            </div>

                            <div class="info-grid">
                                @if($enquiry->email)
                                    <div>
                                        <div class="info-label">Email</div>
                                        <div class="info-value"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></div>
                                    </div>
                                @endif

                                @if($enquiry->mobile)
                                    <div>
                                        <div class="info-label">Mobile</div>
                                        <div class="info-value">
                                            <a href="tel:{{ preg_replace('/[^\d+]/', '', $enquiry->mobile) }}">{{ $enquiry->mobile }}</a>
                                        </div>
                                    </div>
                                @endif

                                @if($enquiry->company)
                                    <div>
                                        <div class="info-label">Company</div>
                                        <div class="info-value">{{ $enquiry->company }}</div>
                                    </div>
                                @endif

                                @if($enquiry->inquiry_type)
                                    <div>
                                        <div class="info-label">Inquiry Type</div>
                                        <div class="info-value">
                                            <span class="inq-tag">
                                                {{ \App\Models\ContactEnquiry::TYPES[$enquiry->inquiry_type] ?? $enquiry->inquiry_type }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="info-label">Message</div>
                            <div class="msg-box">{!! nl2br(e($enquiry->message)) !!}</div>

                        </div>
                    </div>
                </div>

                <!-- RIGHT — sidebar -->
                <div>

                    <!-- Status -->
                    <div class="list-card">
                        <div class="card-head"><h5>Status</h5></div>
                        <div class="card-body-pad">
                            <form method="POST" action="{{ route('admin.contact-enquiries.status', $enquiry->id) }}">
                                @csrf
                                @method('PATCH')
                                <label class="side-label">Update Status</label>
                                <select name="status" class="status-select">
                                    @foreach(\App\Models\ContactEnquiry::STATUSES as $value => $label)
                                        <option value="{{ $value }}" {{ $enquiry->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-accent-dash" style="width:100%">
                                    <i class="fa fa-check"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Quick actions -->
                    @if($enquiry->email || $enquiry->mobile)
                        <div class="list-card">
                            <div class="card-head"><h5>Quick Actions</h5></div>
                            <div class="card-body-pad">
                                <div class="side-actions">
                                    @if($enquiry->email)
                                        <a href="mailto:{{ $enquiry->email }}" class="btn-secondary-dash">
                                            <i class="fa fa-envelope"></i> Send Email
                                        </a>
                                    @endif
                                    @if($enquiry->mobile)
                                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $enquiry->mobile) }}" class="btn-secondary-dash">
                                            <i class="fa fa-phone"></i> Call Customer
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')