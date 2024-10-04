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
                <!-- Tombol yang membuka modal -->
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
                            <th>{{ __('admin.PJ Name') }}</th> <!-- Menambahkan kolom PJ Name -->
                            <th>{{ __('admin.Tim') }}</th>
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
                            <td>{{ $admin->tim }}</td>
                            <td>
                                {{-- <a href="{{ route('admin.user.edit', $admin->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.user.destroy', $admin->id) }}" class="btn btn-danger delete-item">
                                    <i class="fas fa-trash-alt"></i>
                                </a> --}}
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Data -->
                <form method="POST" action="{{ route('admin.register') }}">
                    @csrf
                    @php
                        use App\Models\Admin;
                        use Spatie\Permission\Models\Role;

                        $admins = Admin::with('roles')->get();


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

                    <!-- Select Option untuk Tim -->
                    <div class="form-group">
                        <label for="tim">{{ __('admin.Tim') }}</label>
                        <select class="form-control" id="tim" name="tim">
                            <option value="DS">DS</option>
                            <option value="PKH">PKH</option>
                            <option value="MM">MM</option>
                            <option value="Asyiah">Asyiah</option>
                            <option value="Parpol">Parpol</option>
                            <option value="JJ">JJ</option>
                        </select>
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
