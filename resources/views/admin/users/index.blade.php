@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Anggota Tim') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('admin.All Anggota Tim') }}</h4>
            <div class="card-header-action">
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahDataModal">
                    <i class="fas fa-plus"></i> {{ __('admin.Create new') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>{{ __('admin.Name') }}</th>
                            <th>{{ __('admin.Email') }}</th>
                            <th>{{ __('admin.PJ Name') }}</th>
                            <th>{{ __('admin.Tim') }}</th> <!-- Menampilkan nama tim -->
                            <th>{{ __('admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->admin ? $admin->admin->name : 'N/A' }}</td>
                            <td>{{ $admin->tim ? $admin->tim->name : 'N/A' }}</td> <!-- Menggunakan relasi untuk menampilkan nama tim -->
                            <td>
                                {{-- Edit dan delete buttons bisa diaktifkan kembali jika diperlukan --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">{{ __('admin.Create new') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.register') }}">
                    @csrf
                    @php
                        use App\Models\Admin;
                        use App\Models\tim; // Tambahkan model tim
                        $admins = Admin::with('roles')->get();
                        $tims = tim::all(); // Mengambil semua tim
                    @endphp
                    <div class="form-group">
                        <label for="pj_id">{{ __('admin.Nama Koordinator') }}</label>
                        <select class="form-control" name="pj_id" id="pj_id">
                            <option value="">{{ __('Pilih Koordinator') }}</option>
                            @foreach($admins as $admin)
                                @foreach($admin->roles as $role)
                                    <option value="{{ $admin->id }}">{{ $admin->name }} - {{ $role->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tim_id">{{ __('admin.Tim') }}</label>
                        <select class="form-control" name="tim_id" id="tim_id">
                            <option value="">{{ __('Pilih Tim') }}</option>
                            @foreach($tims as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->name }}</option> <!-- Menampilkan nama tim -->
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input class="form-control" placeholder="{{ __('admin.Name') }}" type="text" name="name">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="{{ __('admin.Email') }}" type="email" name="email">
                        @error('email')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="{{ __('admin.Password') }}" type="password" name="password">
                        @error('password')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="{{ __('admin.Confirm Password') }}" type="password"
                            name="password_confirmation">
                        @error('password_confirmation')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('admin.Simpan') }}</button>
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
            "targets": [2, 3]
        }]
    });
</script>
@endpush
