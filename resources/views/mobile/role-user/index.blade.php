@extends('mobile.frontend.layout.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Roles Users') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('All Role Users') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('role-users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Create new') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Action') }}</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>

                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td><span class="badge bg-primary text-light">{{ $admin->getRoleNames()->first() }}</span></td>

                                <td>
                                    @if ($admin->getRoleNames()->first() != 'Admin')
                                    <div class="btn-group" role="group" aria-label="Admin actions">
                                        <a href="{{ route('role-users.edit', $admin->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('role-users.destroy', $admin->id) }}" class="btn btn-danger delete-item">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
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
                "sortable": false,
                "targets": [2, 3]
            }]
        });

    </script>
@endpush
