@extends('mobile.frontend.layout.master')

@section('content')


<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}"><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>

    <div class="card card-style">
        <div class="content mb-2">
            <h3>Role Permision</h3>
            <a href="{{ route('role.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Create new') }}
            </a>
            <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
                <thead>
                    <tr class="bg-gray1-dark">
                        <th scope="col" class="color-theme">#</th>
                        <th scope="col" class="color-theme">Role Name</th>
                        <th scope="col" class="color-theme">Permissions</th>
                        <th scope="col" class="color-theme">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($roles as $role)
                    <tr>
                        <td scope="row">{{ $role->id }}</td>
                        <td class="color-green1-dark">{{ $role->name }}</td>
                        <td class="color-green1-dark">
                            @foreach ($role->permissions as $permission)
                            <span class="badge bg-primary text-light">{{ $permission->name }}</span>
                            @endforeach
                            @if ($role->name === 'Admin')
                            <span class="badge bg-danger text-light">{{ __('All Permissions') }} *</span>
                            @endif
                        </td>
                        <td class="color-green1-dark">
                            @if ($role->name != 'Admin')
                            <div class="btn-group" role="group" aria-label="Role actions">
                                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('role.destroy', $role->id) }}" class="btn btn-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                            </div>
                            @endif
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
            "sortable": false
            , "targets": [2, 3]
        }]
    });

</script>
@endpush
