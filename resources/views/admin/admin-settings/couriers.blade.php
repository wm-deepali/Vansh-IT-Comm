<form method="POST" action="{{ route('admin.couriers.store') }}" id="courier-form">
    @csrf
    <input type="hidden" name="id" id="courier-id" value="">

    <div class="settings-layout">

        <div class="settings-sidenav">
            <span class="settings-sidenav-label">Courier Management</span>

            <a href="#add-courier" class="active">
                <i class="fa-solid fa-plus"></i> Add Courier
            </a>

            <a href="#courier-list">
                <i class="fa-solid fa-truck"></i> Courier List
            </a>
        </div>

        <div class="settings-content">

            {{-- Add / Edit Courier --}}
            <div id="add-courier" class="settings-section">

                <h3 class="settings-section-title">
                    <i class="fa-solid fa-plus"></i>
                    <span id="courier-form-title">Add New Courier</span>
                </h3>

                <p class="settings-section-desc">
                    Add courier companies that can be selected while updating order tracking details.
                </p>

                <div class="form-grid">

                    <div class="field-group">
                        <label class="field-label">Courier Name <span class="req">*</span></label>
                        <input type="text" name="name" id="courier-name" class="field-input"
                            placeholder="e.g. Delhivery" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Website URL</label>
                        <input type="url" name="website_url" id="courier-url" class="field-input"
                            placeholder="https://www.delhivery.com">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Icon</label>
                        <input type="text" name="icon" id="courier-icon" class="field-input"
                            maxlength="100" placeholder="e.g. fa-solid fa-plane">
                        <div class="field-hint">
                            Font Awesome 6 class shown on the track-order page. Leave empty for the default truck.
                        </div>
                    </div>

                </div>

                <div class="toggle-row mt-3">
                    <div>
                        <div class="toggle-info-label">Active</div>
                        <div class="toggle-info-sub">Show this courier in order tracking dropdown.</div>
                    </div>

                    <label class="toggle-switch">
                        <input type="checkbox" name="is_active" id="courier-active" checked>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div style="margin-top:20px;display:flex;gap:8px;">
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span id="courier-submit-text">Save Courier</span>
                    </button>

                    <button type="button" id="courier-cancel-edit" class="btn-secondary-dash" style="display:none">
                        Cancel Edit
                    </button>
                </div>

            </div>

            <hr class="section-divider">

            {{-- Courier List --}}
            <div id="courier-list" class="settings-section">

                <h3 class="settings-section-title">
                    <i class="fa-solid fa-truck"></i> Courier List
                </h3>

                <p class="settings-section-desc">Manage available courier companies.</p>

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Courier Name</th>
                                <th>Icon</th>
                                <th>Website</th>
                                <th width="100">Status</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($couriers as $courier)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td><strong>{{ $courier->name }}</strong></td>

                                    <td>
                                        @if($courier->icon)
                                            <code style="font-size:11px">{{ $courier->icon }}</code>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if($courier->website_url)
                                            <a href="{{ $courier->website_url }}" target="_blank" rel="noopener">
                                                {{ $courier->website_url }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if($courier->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button type="button"
                                            class="btn btn-sm btn-primary edit-courier-btn"
                                            data-id="{{ $courier->id }}"
                                            data-name="{{ $courier->name }}"
                                            data-url="{{ $courier->website_url }}"
                                            data-icon="{{ $courier->icon }}"
                                            data-active="{{ $courier->is_active ? 1 : 0 }}">
                                            Edit
                                        </button>

                                        <button type="submit"
                                            form="courier-delete-{{ $courier->id }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this courier?')">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No courier found.</td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</form>

{{-- Delete forms live outside the main form (nested forms are invalid HTML) --}}
@foreach($couriers as $courier)
    <form id="courier-delete-{{ $courier->id }}"
        action="{{ route('admin.couriers.delete', $courier) }}"
        method="POST" style="display:none">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<script>
    (function () {
        const $ = id => document.getElementById(id);

        function resetCourierForm() {
            $('courier-form').reset();
            $('courier-id').value = '';
            $('courier-active').checked = true;
            $('courier-form-title').textContent = 'Add New Courier';
            $('courier-submit-text').textContent = 'Save Courier';
            $('courier-cancel-edit').style.display = 'none';
        }

        document.querySelectorAll('.edit-courier-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                $('courier-id').value = btn.dataset.id;
                $('courier-name').value = btn.dataset.name || '';
                $('courier-url').value = btn.dataset.url || '';
                $('courier-icon').value = btn.dataset.icon || '';
                $('courier-active').checked = btn.dataset.active === '1';

                $('courier-form-title').textContent = 'Edit Courier';
                $('courier-submit-text').textContent = 'Update Courier';
                $('courier-cancel-edit').style.display = 'inline-flex';

                $('add-courier').scrollIntoView({ behavior: 'smooth', block: 'start' });
                $('courier-name').focus();
            });
        });

        $('courier-cancel-edit').addEventListener('click', resetCourierForm);
    })();
</script>