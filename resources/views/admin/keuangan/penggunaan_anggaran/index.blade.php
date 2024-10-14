@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Daftar Penggunaan Anggaran') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                    + Penggunaan Anggaran
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tablePenggunaanAnggaran">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Periode ID</th>
                            <th>Detail Pembiayaan ID</th>
                            <th>Jumlah Digunakan</th>
                            <th>Status Pembayaran</th>
                            <th>Bukti Pembayaran</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penggunaanAnggaran as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->periode_id }}</td>
                                <td>{{ $item->detail_pembiayaan_id }}</td>
                                <td>{{ $item->jumlah_digunakan }}</td>
                                <td>{{ $item->status_pembayaran == 1 ? 'Lunas' : 'Belum Lunas' }}</td>
                                <td><img src="{{ $item->bukti_pembayaran }}" alt="Bukti" width="100"></td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $item->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $item->id }}" data-id="{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.keuangan.penggunaan_anggaran.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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
@foreach ($penggunaanAnggaran as $item)
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Penggunaan Anggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> {{ $item->id }}</p>
                    <p><strong>Periode ID:</strong> {{ $item->periode_id }}</p>
                    <p><strong>Detail Pembiayaan ID:</strong> {{ $item->detail_pembiayaan_id }}</p>
                    <p><strong>Jumlah Digunakan:</strong> {{ $item->jumlah_digunakan }}</p>
                    <p><strong>Status Pembayaran:</strong> {{ $item->status_pembayaran == 1 ? 'Lunas' : 'Belum Lunas' }}</p>
                    <p><strong>Bukti Pembayaran:</strong></p>
                    <img src="{{ $item->bukti_pembayaran }}" alt="Bukti" width="100">
                    <p><strong>Keterangan:</strong> {{ $item->keterangan }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal Edit -->
@foreach ($penggunaanAnggaran as $item)
    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.keuangan.penggunaan_anggaran.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Penggunaan Anggaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="periode_id">Periode ID</label>
                            <input type="number" class="form-control" name="periode_id" value="{{ $item->periode_id }}" required>
                        </div>
                        <div class="form-group">
                            <label for="detail_pembiayaan_id">Detail Pembiayaan ID</label>
                            <input type="number" class="form-control" name="detail_pembiayaan_id" value="{{ $item->detail_pembiayaan_id }}" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_digunakan">Jumlah Digunakan</label>
                            <input type="text" class="form-control" name="jumlah_digunakan" value="{{ $item->jumlah_digunakan }}" required>
                        </div>
                        <div class="form-group">
                            <label for="status_pembayaran">Status Pembayaran</label>
                            <select class="form-control" name="status_pembayaran">
                                <option value="1" {{ $item->status_pembayaran == 1 ? 'selected' : '' }}>Lunas</option>
                                <option value="0" {{ $item->status_pembayaran == 0 ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bukti_pembayaran">Bukti Pembayaran</label>
                            <input type="text" class="form-control" name="bukti_pembayaran" value="{{ $item->bukti_pembayaran }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan">{{ $item->keterangan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.keuangan.penggunaan_anggaran.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Penggunaan Anggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="periode_id">Periode ID</label>
                        <input type="number" class="form-control" name="periode_id" required>
                    </div>
                    <div class="form-group">
                        <label for="detail_pembiayaan_id">Detail Pembiayaan ID</label>
                        <input type="number" class="form-control" name="detail_pembiayaan_id" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_digunakan">Jumlah Digunakan</label>
                        <input type="text" class="form-control" name="jumlah_digunakan" required>
                    </div>
                    <div class="form-group">
                        <label for="status_pembayaran">Status Pembayaran</label>
                        <select class="form-control" name="status_pembayaran">
                            <option value="1">Lunas</option>
                            <option value="0">Belum Lunas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran</label>
                        <input type="text" class="form-control" name="bukti_pembayaran">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan"></textarea>
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

@endsection

@section('script')
<script>
    $(document).ready(function() {

            $("#tablePenggunaanAnggaran").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }],
                "order": [
                    [0, 'desc']
                ]
            });
    });
</script>
@endsection
