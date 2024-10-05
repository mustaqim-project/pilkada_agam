@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tim Management</h1>
    <button class="btn btn-primary" id="createTimBtn">Create Tim</button>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tims as $tim)
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

<!-- Modal -->
<div class="modal fade" id="timModal" tabindex="-1" role="dialog" aria-labelledby="timModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timModalLabel">Tim Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                location.reload();
            },
            error: function(xhr) {
                // Handle errors
                console.log(xhr.responseText);
            }
        });
    });
});
</script>
@endsection
