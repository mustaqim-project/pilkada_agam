@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="section-header">
            <h1>{{ __('admin.Detail Pembiayaan') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                        + Detail Pembiayaan
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="tablePembiayaan">
                    <thead>
                        <tr>
                            <th>Jenis Pembiayaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jenisPembiayaans as $jenis)
                            <tr>
                                <td>
                                    <div class="card-header" id="heading{{ $jenis->id }}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $jenis->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $jenis->id }}">
                                                {{ $jenis->nama_pembiayaan }}
                                            </button>
                                        </h2>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                        <a href="#" data-toggle="modal" data-target="#editModal{{ $jenis->id }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.keuangan.jenis_pembiayaan.destroy', $jenis->id) }}"
                                            class="btn btn-danger delete-item">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr id="collapse{{ $jenis->id }}" class="collapse" aria-labelledby="heading{{ $jenis->id }}">
                                <td colspan="2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Rincian</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jenis->detailPembiayaan as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nama_rincian }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                                            <a href="#" data-toggle="modal" data-target="#editModal{{ $item->id }}" class="btn btn-warning">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('admin.keuangan.detail_pembiayaan.destroy', $item->id) }}" class="btn btn-danger delete-item">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.keuangan.detail_pembiayaan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Detail Pembiayaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenis_pembiayaan_id">Jenis Pembiayaan</label>
                            <select name="jenis_pembiayaan_id" class="form-control" required>
                                <option value="">-- Pilih Jenis Pembiayaan --</option>
                                @foreach ($jenisPembiayaans as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        {{ old('jenis_pembiayaan_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_pembiayaan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nama_rincian">Nama Rincian</label>
                            <input type="text" name="nama_rincian" class="form-control"
                                value="{{ old('nama_rincian') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    @foreach ($detailPembiayaan as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.keuangan.detail_pembiayaan.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Detail Pembiayaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="jenis_pembiayaan_id">Jenis Pembiayaan</label>
                                <select name="jenis_pembiayaan_id" class="form-control" required>
                                    <option value="">-- Pilih Jenis Pembiayaan --</option>
                                    @foreach ($jenisPembiayaans as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ $item->jenis_pembiayaan_id == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_pembiayaan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_rincian">Nama Rincian</label>
                                <input type="text" name="nama_rincian" class="form-control"
                                    value="{{ $item->nama_rincian }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('toast_success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('toast_success') }}'
                });
            @endif

            @if (Session::has('toast_error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('toast_error') }}'
                });
            @endif
        });
    </script>
@endsection
