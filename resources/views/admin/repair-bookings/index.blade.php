@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4;--surface:#ffffff;--border:#e3e5e8;--text-primary:#202223;
        --text-secondary:#6d7175;--text-hint:#8c9196;--accent:#303d89;--accent-light:#f0f1fc;
        --green:#007a5e;--green-bg:#e3f1ec;--red:#b22222;--red-bg:#fce8e8;
        --amber:#916a00;--amber-bg:#fff5cc;--blue:#0069d9;--blue-bg:#e8f2ff;
        --radius-sm:8px;--radius-md:12px;
        --shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
        --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }
    .list-page{background:var(--bg);padding:24px 28px;min-height:100vh;font-family:var(--font);color:var(--text-primary);}
    .list-page *{box-sizing:border-box;}
    .list-page-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;}
    .list-page-header h1{font-size:20px;font-weight:650;margin:0;}
    .crumb{font-size:12.5px;color:var(--text-hint);margin-top:3px;}
    .crumb a{color:var(--accent);text-decoration:none;}
    .crumb a:hover{text-decoration:underline;}
    .crumb span{margin:0 5px;}
    .filter-select{height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 12px;font-size:13px;font-family:var(--font);background:var(--surface);color:var(--text-primary);outline:none;}
    .filter-select:focus{border-color:var(--accent);}
    .list-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden;}
    .data-table{width:100%;border-collapse:collapse;}
    .data-table thead tr{background:#fafafa;border-bottom:1px solid var(--border);}
    .data-table thead th{padding:10px 16px;font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);white-space:nowrap;text-align:left;}
    .data-table tbody tr.main-row{border-bottom:1px solid var(--border);transition:background .12s;}
    .data-table tbody tr.main-row:hover{background:#fafbfc;}
    .data-table td{padding:13px 16px;font-size:13px;vertical-align:middle;}
    .id-chip{display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:2px 8px;font-size:11.5px;font-family:'SF Mono','Fira Mono',monospace;color:var(--text-secondary);}
    .cust-name{font-size:13px;font-weight:600;}
    .cust-sub{font-size:11.5px;color:var(--text-hint);}
    .cust-sub a{color:var(--accent);text-decoration:none;}
    .issue-tag{display:inline-flex;padding:3px 10px;border-radius:6px;font-size:12px;font-weight:600;background:var(--amber-bg);color:var(--amber);border:1px solid rgba(145,106,0,.15);}
    .status-select{height:32px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 8px;font-size:12.5px;font-family:var(--font);background:var(--surface);color:var(--text-primary);outline:none;font-weight:600;}
    .status-select:focus{border-color:var(--accent);}
    .date-cell{font-size:12.5px;color:var(--text-secondary);white-space:nowrap;}
    .action-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--surface);color:var(--text-secondary);cursor:pointer;transition:all .15s;font-size:12px;}
    .action-btn:hover{background:var(--bg);color:var(--text-primary);}
    .action-btn.view:hover{background:var(--blue-bg);color:var(--blue);border-color:rgba(0,105,217,.25);}
    .action-btn.danger:hover{background:var(--red-bg);color:var(--red);border-color:#f5c0c0;}
    .details-row{display:none;background:#fafbfc;border-bottom:1px solid var(--border);}
    .details-box{padding:14px 20px 18px;font-size:13px;line-height:1.7;}
    .details-box .d-label{font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);}
    .empty-state{text-align:center;padding:56px 24px;}
    .empty-icon-wrap{width:56px;height:56px;border-radius:50%;background:var(--accent-light);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:22px;}
    .empty-state h6{font-size:14px;font-weight:650;margin:0 0 6px;}
    .empty-state p{font-size:13px;color:var(--text-hint);margin:0;}
    .pagination-bar{padding:14px 20px;border-top:1px solid var(--border);}
    .pagination-bar .pagination{margin:0;}
    .pagination-bar .page-link{border-color:var(--border);color:var(--accent);font-size:13px;border-radius:var(--radius-sm) !important;margin:0 2px;}
    .pagination-bar .page-item.active .page-link{background:var(--accent);border-color:var(--accent);color:#fff;}
    @media(max-width:768px){.list-page{padding:16px;}}
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Repair Bookings</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Repair Bookings
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.repair-bookings.index') }}">
                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        @foreach(\App\Models\RepairBooking::STATUSES as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="list-card">
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:100px">Ticket</th>
                                <th style="min-width:170px">Customer</th>
                                <th style="min-width:170px">Device</th>
                                <th style="min-width:180px">Issue</th>
                                <th style="width:150px">Status</th>
                                <th style="width:120px">Date</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $item)

                                <tr class="main-row" id="row{{ $item->id }}">
                                    <td><span class="id-chip">{{ $item->ticket_no ?: '#' . $item->id }}</span></td>

                                    <td>
                                        <div class="cust-name">{{ $item->name }}</div>
                                        <div class="cust-sub">
                                            <a href="tel:{{ preg_replace('/[^\d+]/', '', $item->mobile) }}">{{ $item->mobile }}</a>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="cust-name">{{ $item->brand }}{{ $item->model ? ' · ' . $item->model : '' }}</div>
                                        @if($item->device_type)
                                            <div class="cust-sub">{{ $item->device_type }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->issue)
                                            <span class="issue-tag">{{ $item->issue }}</span>
                                        @else
                                            <span class="cust-sub">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        <select class="status-select" onchange="changeStatus({{ $item->id }}, this.value)">
                                            @foreach(\App\Models\RepairBooking::STATUSES as $value => $label)
                                                <option value="{{ $value }}" {{ $item->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="date-cell">
                                        {{ $item->created_at->format('d M Y') }}
                                        <div style="font-size:11.5px;color:var(--text-hint)">{{ $item->created_at->format('h:i A') }}</div>
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <button class="action-btn view" title="Details" onclick="$('#details{{ $item->id }}').toggle()">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button class="action-btn danger" title="Delete" onclick="deleteBooking({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="details-row" id="details{{ $item->id }}">
                                    <td colspan="7">
                                        <div class="details-box">
                                            @if($item->service_mode)
                                                <div><span class="d-label">Service Mode:</span> {{ $item->service_mode }}</div>
                                            @endif
                                            <div>
                                                <span class="d-label">Details:</span>
                                                {{ $item->description ?: 'No additional details provided.' }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap"><i class="fa fa-wrench"></i></div>
                                            <h6>No Bookings Found</h6>
                                            <p>Repair bookings from the website will appear here.</p>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($bookings, 'hasPages') && $bookings->hasPages())
                    <div class="pagination-bar">
                        {{ $bookings->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function changeStatus(id, status) {
    $.ajax({
        url: "{{ url('admin/repair-bookings') }}/" + id + "/status",
        type: "PATCH",
        data: { _token: "{{ csrf_token() }}", status: status },
        success: function (res) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, timer: 1500, showConfirmButton: false });
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong', 'error');
        }
    });
}

function deleteBooking(id) {
    Swal.fire({
        title: 'Delete Booking?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/repair-bookings') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id + ", #details" + id).fadeOut(400, function () { $(this).remove(); });
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            });
        }
    });
}
</script>