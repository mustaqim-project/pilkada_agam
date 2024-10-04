@extends('mobile.frontend.layout.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Role And Permissions') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Update Role') }}</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">{{__('Role Name')}}</label>
                        <input type="text" class="form-control" name="role" value="{{ $role->name }}">
                        @error('role')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr>
                    @foreach ($permissions as $groupName => $permissions)
                    <div class="form-group">
                        <h6 class="text-primary">{{ $groupName }}</h6>
                        <div class="row">
                            @foreach ($permissions as $item)
                            <div class="col-md-2">
                                <label class="custom-switch mt-2">
                                    <input
                                    {{ in_array($item->name, $rolesPermissions) ? 'checked' : '' }}
                                    value="{{ $item->name }}" type="checkbox" name="permissions[]" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description text-primary">{{ $item->name }}</span>
                                </label>

                            </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    @endforeach

                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
