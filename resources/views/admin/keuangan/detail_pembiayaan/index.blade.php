@extends('admin.layouts.master')

@section('content')
    <section class="section">
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
                <div class="table-responsive">
                    <table class="table table-striped" id="tableDetailPembiayaan">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jenis Pembiayaan ID</th>
                                <th>Nama Rincian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailPembiayaan as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->jenis_pembiayaan_id }}</td>
                                    <td>{{ $item->nama_rincian }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                            <button class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#detailModal{{ $item->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#editModal{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <a href="{{ route('admin.keuangan.detail_pembiayaan.destroy', $item->id) }}"
                                                class="btn btn-danger delete-item"><i
                                                    class="fas fa-trash-alt"></i></a>
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

    <!-- Modal Detail -->
    @foreach ($detailPembiayaan as $item)
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Pembiayaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ $item->id }}</p>
                        <p><strong>Jenis Pembiayaan ID:</strong> {{ $item->jenis_pembiayaan_id }}</p>
                        <p><strong>Nama Rincian:</strong> {{ $item->nama_rincian }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

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
                            <label for="jenis_pembiayaan_id">Jenis Pembiayaan ID</label>
                            <input type="number" name="jenis_pembiayaan_id" class="form-control" value="{{ old('jenis_pembiayaan_id') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_rincian">Nama Rincian</label>
                            <input type="text" name="nama_rincian" class="form-control" value="{{ old('nama_rincian') }}" required>
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
                                <label for="jenis_pembiayaan_id">Jenis Pembiayaan ID</label>
                                <input type="number" name="jenis_pembiayaan_id" class="form-control" value="{{ $item->jenis_pembiayaan_id }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_rincian">Nama Rincian</label>
                                <input type="text" name="nama_rincian" class="form-control" value="{{ $item->nama_rincian }}" required>
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
@endsection
