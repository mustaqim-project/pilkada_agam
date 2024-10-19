@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Edit User') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('admin.Edit User with Role') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.role-users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>{{ __('admin.User Name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('admin.Email') }}</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('admin.Password') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <small class="text-muted">{{ __('Leave blank if you do not want to change the password') }}</small>
                </div>

                <div class="form-group">
                    <label>{{ __('admin.Kode Bank') }}</label>
                    <select name="kode_bank" class="form-control select2">
                        <option value="">{{ __('admin.--Select--') }}</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->kode_bank }}" {{ old('kode_bank', $user->bank->kode_bank) == $bank->kode_bank ? 'selected' : '' }}>
                                {{ $bank->nama_bank }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_bank')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>


                <div class="form-group">
                    <label>{{ __('admin.No Rekening') }}</label>
                    <input type="text" class="form-control" name="no_rek" value="{{ old('no_rek', $user->no_rek) }}">
                    @error('no_rek')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('admin.Jumlah Gaji Perperiode') }}</label>
                    <input type="text" class="form-control" name="jum_gaji" value="{{ old('jum_gaji', $user->jum_gaji) }}">
                    @error('jum_gaji')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('admin.Tim') }}</label>
                    <select name="tim_id" class="select2 form-control" id="tim_id">
                        <option value="">{{ __('admin.--Select--') }}</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ old('tim_id', $user->tim->tim_id) == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tim_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('admin.Jabatan') }}</label>
                    <select name="jabatan_id" class="select2 form-control" id="jabatan_id">
                        <option value="">{{ __('admin.--Select--') }}</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}" {{ old('jabatan_id', $user->jabatan->jabatan_id) == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('admin.Atasan') }}</label>
                    <select name="atasan_id" class="select2 form-control" id="atasan_id">
                        <option value="">{{ __('admin.--Select--') }}</option>
                        @foreach ($admins as $admin)
                            <option value="{{ $admin->id }}" {{ old('atasan_id', $user->atasan_id) == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('atasan_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('admin.Role') }}</label>
                    <select name="role" class="select2 form-control">
                        <option value="">{{ __('admin.--Select--') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role', $user->getRoleNames()->first()) == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('admin.Update') }}</button>
            </form>
        </div>
    </div>
</section>
@endsection
