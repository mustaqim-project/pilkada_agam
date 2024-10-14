@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Team Management') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button class="btn btn-primary" id="createTimBtn" data-toggle="modal" data-target="#createTimModal">
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
                                <button class="btn btn-warning editTimBtn" data-id="{{ $tim->id }}" data-name="{{ $tim->name }}" data-toggle="modal" data-target="#editTimModal">Edit</button>
                                <form action="{{ route('admin.tims.destroy', $tim->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger delete-item" type="submit" >Delete</button>
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

<!-- Modal Create -->
<div class="modal fade" id="createTimModal" tabindex="-1" role="dialog" aria-labelledby="createTimModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTimModalLabel">{{ __('admin.Create Team') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createTimForm" action="{{ route('admin.tims.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('admin.Name') }}</label>
                        <input type="text" class="form-control" name="name" id="createName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editTimModal" tabindex="-1" role="dialog" aria-labelledby="editTimModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTimModalLabel">{{ __('admin.Edit Team') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTimForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editTimId">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('admin.Name') }}</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $("#table").dataTable({
        "columnDefs": [{
            "sortable": false,
            "targets": [2]
        }],
        "order": [
            [0, 'asc']
        ]
    });

    // Handle Edit Button Click
    $('.editTimBtn').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $.get(`/admin/tims/${id}/edit`, function(data) {
            $('#editTimId').val(id);
            $('#editName').val(name);
            $('#editTimForm').attr('action', `/admin/tims/${id}`);
        });
    });
</script>
@endpush
