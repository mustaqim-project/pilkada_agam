@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Role User') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('admin.Create User with Role') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.role-users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="">{{ __('admin.User Name') }}</label>
                        <input type="text" class="form-control" name="name">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Email') }}</label>
                        <input type="email" class="form-control" name="email">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Password') }}</label>
                        <input type="password" class="form-control" name="password">
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Confirm Password') }}</label>
                        <input type="password" class="form-control" name="password_confirmation">
                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select for kode_bank -->
                    <div class="form-group">
                        <label for="kode_bank">{{ __('admin.Kode Bank') }}</label>
                        <select name="kode_bank" class="form-control select2">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->kode_bank }}"
                                    {{ old('kode_bank') == $bank->kode_bank ? 'selected' : '' }}>
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_bank')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input for no_rek -->
                    <div class="form-group">
                        <label for="no_rek">{{ __('admin.No Rekening') }}</label>
                        <input type="text" class="form-control" name="no_rek" value="{{ old('no_rek') }}">
                        @error('no_rek')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="">{{ __('admin.Atasan') }}</label>
                        <select name="atasan_id" class="select2 form-control">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($admins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                            @endforeach
                        </select>
                        @error('atasan_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Tim') }}</label>
                        <select name="tim_id" class="select2 form-control">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                        @error('tim_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Jabatan') }}</label>
                        <select name="jabatan_id" class="select2 form-control">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        @error('jabatan_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Role') }}</label>
                        <select name="role" id="" class="select2 form-control">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('admin.Create') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
