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
                                    <td>{{ $admin->admin->name ?? 'N/A' }}</td>
                                    <td>{{ $admin->tim->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                            <a href="#" data-toggle="modal"
                                                data-target="#editDataModal{{ $admin->id }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.register.destroy', $admin->id) }}"
                                                class="btn btn-danger delete-item">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @foreach ($admins as $admin)
        <div class="modal fade" id="editDataModal{{ $admin->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editDataModalLabel{{ $admin->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel{{ $admin->id }}">
                            {{ __('admin.Edit Anggota Tim') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.register.update', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ __('admin.Name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ $admin->name }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('admin.Email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ $admin->email }}"
                                    required>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pj_id">{{ __('admin.Nama Koordinator') }}</label>
                                <select class="form-control" name="pj_id" id="pj_id">
                                    <option value="">{{ __('Pilih Koordinator') }}</option>
                                    @foreach ($admins as $admin)
                                    @foreach ($admin->roles as $role)
                                        <option value="{{ $admin->id }}">{{ $admin->name }} - {{ $role->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tim_id">{{ __('admin.Tim') }}</label>
                                <select class="form-control" name="tim_id" id="tim_id">
                                    @foreach ($tims as $tim)
                                        <option value="{{ $tim->id }}"
                                            {{ $admin->tim_id == $tim->id ? 'selected' : '' }}>
                                            {{ $tim->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('admin.Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('admin.Save changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

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
                    <form method="POST" action="{{ route('admin.register.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="pj_id">{{ __('admin.Nama Koordinator') }}</label>
                            <select class="form-control" name="pj_id" id="pj_id">
                                <option value="">{{ __('Pilih Koordinator') }}</option>
                                @foreach ($admins as $admin)
                                    @foreach ($admin->roles as $role)
                                        <option value="{{ $admin->id }}">{{ $admin->name }} - {{ $role->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tim_id">{{ __('admin.Tim') }}</label>
                            <select class="form-control" name="tim_id" id="tim_id">
                                <option value="">{{ __('Pilih Tim') }}</option>
                                @foreach ($tims as $tim)
                                    <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input class="form-control" placeholder="{{ __('admin.Name') }}" type="text"
                                name="name" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="{{ __('admin.Email') }}" type="email"
                                name="email" required>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="{{ __('admin.Password') }}" type="password"
                                name="password" required>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="{{ __('admin.Confirm Password') }}" type="password"
                                name="password_confirmation" required>
                            @error('password_confirmation')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('admin.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('admin.Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
