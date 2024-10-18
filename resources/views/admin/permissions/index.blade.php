@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Permission') }}</h1>
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
                                <th>Guard Name</th>
                                <th>Group Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>{{ $permission->group_name }}</td>
                                    <td>{{ $permission->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                            class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
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
    </script>
@endpush
