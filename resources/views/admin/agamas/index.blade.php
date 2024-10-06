@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Agama') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button class="btn btn-primary" id="createAgamaBtn" data-bs-toggle="modal" data-bs-target="#newAgamaModal">
                    <i class="fas fa-plus"></i> {{ __('admin.Create new') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agamas as $agama)
                        <tr>
                            <td>{{ $agama->id }}</td>
                            <td>{{ $agama->name }}</td>
                            <td>
                                <!-- Tombol Edit Agama -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAgamaModal" data-id="{{ $agama->id }}">Edit</button>

                                <!-- Tombol Hapus Agama -->
                                <form action="{{ route('admin.agamas.destroy', $agama->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');" aria-label="Delete {{ $agama->name }}">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Agama -->
<div class="modal fade" id="newAgamaModal" tabindex="-1" aria-labelledby="newAgamaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAgamaModalLabel">{{ __('admin.New Agama Form') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form id="newAgamaForm" action="{{ route('admin.agamas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('admin.Name') }}</label>
                        <input type="text" class="form-control" name="name" id="newName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Agama -->
<div class="modal fade" id="editAgamaModal" tabindex="-1" aria-labelledby="editAgamaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAgamaModalLabel">{{ __('admin.Edit Agama Form') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form id="editAgamaForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editAgamaId">
                    <div class="mb-3">
                        <label for="editName" class="form-label">{{ __('admin.Name') }}</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal Create Agama
    $('#newAgamaForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#newAgamaModal').modal('hide');
                location.reload(); // Reload page to reflect new data
            },
            error: function(xhr) {
                console.error('Error saving data:', xhr.responseText);
                alert('Error saving data. Please check your input.');
            }
        });
    });

    // Show modal Edit Agama
    $('#editAgamaModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        // Fetch data Agama untuk modal edit
        $.get(`/admin/agamas/${id}/edit`, function(data) {
            $('#editName').val(data.name);
            $('#editAgamaForm').attr('action', `/admin/agamas/${id}`);
        });
    });

    // Modal Edit Agama
    $('#editAgamaForm').on('submit', function(e) {
        e.preventDefault();
        var actionUrl = $(this).attr('action');

        $.ajax({
            url: actionUrl,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editAgamaModal').modal('hide');
                location.reload(); // Reload page to reflect changes
            },
            error: function(xhr) {
                console.error('Error updating data:', xhr.responseText);
                alert('Error updating data. Please check your input.');
            }
        });
    });
</script>
@endpush
