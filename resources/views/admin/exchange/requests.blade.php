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
            --sp-accent-light: #eef0fc;
            --sp-red: #c0392b;
            --sp-red-bg: #fce8e8;
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

        .sp-card {
            background: var(--sp-surface);
            border-radius: var(--sp-radius-lg);
            box-shadow: var(--sp-shadow-card);
            border: 1px solid var(--sp-border);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .sp-table-wrap {
            overflow-x: auto;
        }

        .sp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .sp-table th {
            text-align: left;
            padding: 11px 14px;
            background: #fafafa;
            border-bottom: 1px solid var(--sp-border);
            font-size: 11.5px;
            font-weight: 650;
            color: var(--sp-text-secondary);
            text-transform: uppercase;
            letter-spacing: .04em;
            white-space: nowrap;
        }

        .sp-table td {
            padding: 11px 14px;
            border-bottom: 1px solid var(--sp-border);
            vertical-align: middle;
        }

        .sp-table tr:last-child td {
            border-bottom: 0;
        }

        .sp-empty {
            text-align: center;
            color: var(--sp-text-hint);
            padding: 28px !important;
        }

        .sp-select {
            height: 32px;
            border: 1px solid var(--sp-border);
            border-radius: var(--sp-radius-md);
            padding: 0 8px;
            font-size: 12.5px;
            background: var(--sp-surface);
            font-family: var(--sp-font);
        }

        .sp-mini-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: var(--sp-radius-sm);
            border: 1px solid var(--sp-border);
            background: var(--sp-surface);
            color: var(--sp-text-secondary);
            cursor: pointer;
            font-size: 12px;
            transition: all .15s;
        }

        .sp-mini-btn.danger:hover {
            background: var(--sp-red-bg);
            color: var(--sp-red);
            border-color: #f5c0c0;
        }

        .sp-btn-light {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: var(--sp-radius-md);
            font-size: 13.5px;
            font-weight: 580;
            font-family: var(--sp-font);
            text-decoration: none;
            background: var(--sp-surface);
            color: var(--sp-text-secondary);
            border: 1px solid var(--sp-border);
        }

        .sp-btn-light:hover {
            background: var(--sp-bg);
            color: var(--sp-text-primary);
        }

        .sp-pager {
            padding: 12px 16px;
        }

        @media (max-width: 768px) {
            .sp-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="sp-page">

            <div class="sp-page-header">
                <div>
                    <h1 class="sp-page-title">Exchange Valuation Requests</h1>
                    <div class="sp-crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <a href="{{ route('admin.exchange-page.edit') }}">Device Exchange</a>
                        <span style="color:var(--sp-border-hover)">›</span>
                        <span>Requests</span>
                    </div>
                </div>
                <a href="{{ route('admin.exchange-page.edit') }}" class="sp-btn-light">
                    <i class="fa fa-arrow-left"></i> Back to Exchange Page
                </a>
            </div>

            <div class="sp-card">
                <div class="sp-table-wrap">
                    <table class="sp-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Brand / Model</th>
                                <th>Condition</th>
                                <th>Age</th>
                                <th>Specs</th>
                                <th>Charger</th>
                                <th>Estimate (₹)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td style="white-space:nowrap">{{ $r->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $r->category }}</td>
                                    <td>{{ $r->brand }} {{ $r->model }}</td>
                                    <td>{{ $r->condition }}</td>
                                    <td>{{ $r->age }}</td>
                                    <td>{{ $r->specs }}</td>
                                    <td>{{ $r->charger }}</td>
                                    <td style="white-space:nowrap">{{ number_format($r->estimated_min) }} –
                                        {{ number_format($r->estimated_max) }}</td>
                                    <td>
                                        <select class="sp-select status-sel" data-id="{{ $r->id }}">
                                            @foreach(['new', 'contacted', 'completed', 'cancelled'] as $s)
                                                <option value="{{ $s }}" {{ $r->status === $s ? 'selected' : '' }}>
                                                    {{ ucfirst($s) }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="sp-mini-btn danger del-req" data-id="{{ $r->id }}"
                                            title="Delete"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="sp-empty">No valuation requests yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="sp-pager">{{ $requests->links() }}</div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    const reqBase = "{{ url('admin/exchange-requests') }}";
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    $('.status-sel').on('change', function () {
        $.post(reqBase + '/' + $(this).data('id') + '/status', { status: $(this).val() })
            .done(function (r) {
                Swal.fire({ icon: 'success', text: r.message, timer: 1000, showConfirmButton: false });
            });
    });

    $('.del-req').on('click', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Delete this request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
        }).then(function (r) {
            if (r.isConfirmed) {
                $.ajax({ url: reqBase + '/' + id, type: 'DELETE' }).done(function () { location.reload(); });
            }
        });
    });
</script>