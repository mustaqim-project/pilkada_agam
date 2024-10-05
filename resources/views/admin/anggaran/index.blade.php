@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Kelola Anggaran</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Anggaran -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahAnggaran">
        Tambah Anggaran
    </button>

    <!-- Tabel Data Anggaran -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tim</th>
                <th>Total Anggaran</th>
                <th>Jumlah Periode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggarans as $anggaran)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $anggaran->tim->name }}</td>
                    <td>{{ number_format($anggaran->total_anggaran, 2) }}</td>
                    <td>{{ $anggaran->jumlah_periode }}</td>
                    <td>
                        <!-- Tombol Edit Anggaran -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditAnggaran" data-id="{{ $anggaran->id }}">
                            Edit
                        </button>
                        <!-- Tombol Hapus Anggaran -->
                        <form action="{{ route('admin.anggaran.destroy', $anggaran->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus anggaran ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Anggaran -->
<div class="modal fade" id="modalTambahAnggaran" tabindex="-1" aria-labelledby="modalTambahAnggaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.anggaran.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAnggaranLabel">Tambah Anggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tim_id" class="form-label">Tim</label>
                        <select name="tim_id" id="tim_id" class="form-control" required>
                            <option value="">Pilih Tim</option>
                            @foreach($tims as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="total_anggaran" class="form-label">Total Anggaran</label>
                        <input type="number" name="total_anggaran" id="total_anggaran" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_periode" class="form-label">Jumlah Periode</label>
                        <input type="number" name="jumlah_periode" id="jumlah_periode" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Anggaran -->
<div class="modal fade" id="modalEditAnggaran" tabindex="-1" aria-labelledby="modalEditAnggaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditAnggaran" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditAnggaranLabel">Edit Anggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tim_id" class="form-label">Tim</label>
                        <select name="tim_id" id="edit_tim_id" class="form-control" required>
                            <option value="">Pilih Tim</option>
                            @foreach($tims as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_total_anggaran" class="form-label">Total Anggaran</label>
                        <input type="number" name="total_anggaran" id="edit_total_anggaran" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah_periode" class="form-label">Jumlah Periode</label>
                        <input type="number" name="jumlah_periode" id="edit_jumlah_periode" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#modalEditAnggaran').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        // Fetch data anggaran berdasarkan ID
        $.get(`/admin/anggaran/${id}/edit`, function (data) {
            $('#edit_tim_id').val(data.tim_id);
            $('#edit_total_anggaran').val(data.total_anggaran);
            $('#edit_jumlah_periode').val(data.jumlah_periode);

            // Ubah action form untuk update
            $('#formEditAnggaran').attr('action', `/admin/anggaran/${id}`);
        });
    });
</script>
@endpush
