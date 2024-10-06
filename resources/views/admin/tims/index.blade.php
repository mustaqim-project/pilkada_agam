@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Team Management') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('admin.All Teams') }}</h4>
            <div class="card-header-action">
                <button class="btn btn-primary" id="createTimBtn" data-toggle="modal" data-target="#timModal">
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
                                        <button class="btn btn-danger" type="submit">Delete</button>
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

<!-- Modal -->
<div class="modal fade" id="timModal" tabindex="-1" role="dialog" aria-labelledby="timModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timModalLabel">Team Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="timForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="formMethod">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
        $('#createTimBtn').on('click', function() {
            $('#timModal').modal('show');
            $('#timForm')[0].reset();
            $('#formMethod').val('POST');
            $('#timForm').attr('action', '{{ route('admin.tims.store') }}');
        });

        $('.editTimBtn').on('click', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `/admin/tims/${id}/edit`,
                method: 'GET',
                success: function(response) {
                    $('#timModal').modal('show');
                    $('#name').val(response.data.name);
                    $('#formMethod').val('PUT');
                    $('#timForm').attr('action', `/admin/tims/${id}`);
                },
                error: function(xhr) {
                    // Handle errors
                    alert('Error fetching data. Please try again.');
                    console.log(xhr.responseText);
                }
            });
        });

        $('#timForm').on('submit', function(e) {
            e.preventDefault();
            const actionUrl = $(this).attr('action');
            const method = $('#formMethod').val();
            $.ajax({
                url: actionUrl,
                method: method,
                data: $(this).serialize(),
                success: function(response) {
                    $('#timModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    // Handle errors
                    alert('Error saving data. Please check your input.');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
