@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Role User') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('admin.Update User') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.role-users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="">{{__('admin.User Name')}}</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{__('admin.Email')}}</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
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
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">{{ __('admin.Confirm Password') }}</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                            <div class="input-group-append">
                                <span class="input-group-text" id="togglePasswordConfirmation" style="cursor: pointer;">
                                    <i class="fa fa-eye" id="eyeIconConfirmation"></i>
                                </span>
                            </div>
                        </div>
                        @error('password_confirmation')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kode_bank">{{ __('admin.Kode Bank') }}</label>
                        <select name="kode_bank" class="form-control select2">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->kode_bank }}" {{ $user->kode_bank === $bank->kode_bank ? 'selected' : '' }}>
                                    {{ $bank->nama_bank }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_bank')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="no_rek">{{ __('admin.No Rekening') }}</label>
                        <input type="text" class="form-control" name="no_rek" value="{{ $user->no_rek }}">
                        @error('no_rek')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jum_gaji">{{ __('admin.Jumlah Gaji Perperiode') }}</label>
                        <input type="text" class="form-control" name="jum_gaji" value="{{ $user->jum_gaji }}">
                        @error('jum_gaji')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Tim') }}</label>
                        <select name="tim_id" class="select2 form-control" id="tim_id">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ $user->tim_id === $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tim_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Jabatan') }}</label>
                        <select name="jabatan_id" class="select2 form-control" id="jabatan_id">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" {{ $user->jabatan_id === $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('jabatan_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Atasan') }}</label>
                        <select name="atasan_id" class="select2 form-control" id="atasan_id">
                            <option value="">{{ __('admin.--Select--') }}</option>
                        </select>
                        @error('atasan_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Role') }}</label>
                        <select name="role" id="" class="select2 form-control">
                            <option value="">{{ __('admin.--Select--') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $role->name === $user->getRoleNames()->first() ? 'selected' : '' }}>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tim_id, #jabatan_id').on('change', function() {
                const timId = $('#tim_id').val();
                const jabatanId = $('#jabatan_id').val();

                if (timId && jabatanId) {
                    $.ajax({
                        url: '{{ route('admin.get-atasan') }}',
                        type: 'GET',
                        data: {
                            tim_id: timId,
                            jabatan_id: jabatanId
                        },
                        success: function(data) {
                            const atasanSelect = $('#atasan_id');
                            atasanSelect.empty();
                            atasanSelect.append('<option value="">--Select--</option>');

                            data.forEach(function(admin) {
                                atasanSelect.append(
                                    `<option value="${admin.id}">${admin.name}</option>`
                                );
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#atasan_id').empty().append('<option value="">--Select--</option>');
                }
            });
        });
    </script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const isPasswordVisible = passwordInput.type === 'text';

            passwordInput.type = isPasswordVisible ? 'password' : 'text';
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');
            const isPasswordVisible = passwordConfirmationInput.type === 'text';

            passwordConfirmationInput.type = isPasswordVisible ? 'password' : 'text';
            eyeIconConfirmation.classList.toggle('fa-eye');
            eyeIconConfirmation.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
