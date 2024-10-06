@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Agama') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('admin.All Agama') }}</h4>
            <div class="card-header-action">
                <button class="btn btn-primary" id="createAgamaBtn" data-toggle="modal" data-target="#agamaModal">
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
                                <button class="btn btn-warning editAgamaBtn" data-id="{{ $agama->id }}">Edit</button>
                                <form action="{{ route('admin.agamas.destroy', $agama->id) }}" method="POST" style="display:inline;">
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
<div class="modal fade" id="agamaModal" tabindex="-1" role="dialog" aria-labelledby="agamaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agamaModalLabel">{{ __('admin.Agama Form') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="agamaForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="formMethod">
                    <div class="form-group">
                        <label for="name">{{ __('admin.Name') }}</label>
                        <input type="text" class="form-control" name="name" id="name" required>
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#createAgamaBtn').on('click', function() {
        $('#agamaModal').modal('show');
        $('#agamaForm')[0].reset();
        $('#formMethod').val('POST');
        $('#agamaForm').attr('action', '{{ route('admin.agamas.store') }}');
    });

    $('.editAgamaBtn').on('click', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/admin/agamas/${id}/edit`,
            method: 'GET',
            success: function(response) {
                $('#agamaModal').modal('show');
                $('#name').val(response.data.name);
                $('#formMethod').val('PUT');
                $('#agamaForm').attr('action', `/admin/agamas/${id}`);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    $('#agamaForm').on('submit', function(e) {
        e.preventDefault();
        const actionUrl = $(this).attr('action');
        const method = $('#formMethod').val();
        $.ajax({
            url: actionUrl,
            method: method,
            data: $(this).serialize(),
            success: function(response) {
                location.reload(); // Refresh the page to reflect changes
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                // Optionally handle error display to the user
            }
        });
    });
});
</script>
@endsection
