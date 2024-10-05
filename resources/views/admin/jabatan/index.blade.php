@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Jabatan Management</h1>
    <button class="btn btn-primary" id="createJabatanBtn">Create Jabatan</button>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jabatans as $jabatan)
            <tr>
                <td>{{ $jabatan->id }}</td>
                <td>{{ $jabatan->name }}</td>
                <td>
                    <button class="btn btn-warning editJabatanBtn" data-id="{{ $jabatan->id }}">Edit</button>
                    <form action="{{ route('admin.jabatan.destroy', $jabatan->id) }}" method="POST" style="display:inline;">
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
<div class="modal fade" id="jabatanModal" tabindex="-1" role="dialog" aria-labelledby="jabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jabatanModalLabel">Jabatan Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="jabatanForm" action="" method="POST">
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
    $('#createJabatanBtn').on('click', function() {
        $('#jabatanModal').modal('show');
        $('#jabatanForm')[0].reset();
        $('#formMethod').val('POST');
        $('#jabatanForm').attr('action', '{{ route('admin.jabatan.store') }}');
    });

    $('.editJabatanBtn').on('click', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/admin/jabatan/${id}/edit`,
            method: 'GET',
            success: function(response) {
                $('#jabatanModal').modal('show');
                $('#name').val(response.data.name);
                $('#formMethod').val('PUT');
                $('#jabatanForm').attr('action', `/admin/jabatan/${id}`);
            }
        });
    });

    $('#jabatanForm').on('submit', function(e) {
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
