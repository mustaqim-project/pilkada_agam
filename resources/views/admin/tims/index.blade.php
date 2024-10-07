@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Team Management') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button class="btn btn-primary" id="createTimBtn" data-bs-toggle="modal" data-bs-target="#newTimModal">
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
                        @foreach ($tims as $tim)
                        <tr>
                            <td>{{ $tim->id }}</td>
                            <td>{{ $tim->name }}</td>
                            <td>
                                <button class="btn btn-warning editTimBtn" data-id="{{ $tim->id }}">Edit</button>
                                <form action="{{ route('admin.tims.destroy', $tim->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
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

<!-- Modal for New Team -->
<div class="modal fade" id="newTimModal" tabindex="-1" aria-labelledby="newTimModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTimModalLabel">{{ __('admin.Create New Team') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form id="newTimForm" action="{{ route('admin.tims.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('admin.Name') }}</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Edit Team -->
<div class="modal fade" id="editTimModal" tabindex="-1" aria-labelledby="editTimModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTimModalLabel">{{ __('admin.Edit Team') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form id="editTimForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">{{ __('admin.Name') }}</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Create New Team Modal
        $('#createTimBtn').on('click', function() {
            $('#newTimModal').modal('show');
            $('#newTimForm')[0].reset();
        });

        // Edit Team Modal
        $('.editTimBtn').on('click', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `/admin/tims/${id}/edit`,
                method: 'GET',
                success: function(response) {
                    $('#editTimModal').modal('show');
                    $('#edit_name').val(response.data.name);
                    $('#editTimForm').attr('action', `/admin/tims/${id}`);
                },
                error: function(xhr) {
                    alert('Error fetching data. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        });

        // Submit Edit Form
        $('#editTimForm').on('submit', function(e) {
            e.preventDefault();
            const actionUrl = $(this).attr('action');
            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editTimModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error saving data. Please check your input.');
                    console.error(xhr.responseText);
                }
            });
        });

        // Submit New Form
        $('#newTimForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#newTimModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error saving data. Please check your input.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
