@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Laporan Keuangan') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button class="btn btn-primary" id="createKeuanganBtn" data-bs-toggle="modal" data-bs-target="#laporanModal" onclick="resetForm()">
                    <i class="fas fa-plus"></i> {{ __('admin.Create new') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggaran</th>
                            <th>Periode</th>
                            <th>Jenis Pembiayaan</th>
                            <th>Jumlah Digunakan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanKeuangan as $laporan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $laporan->anggaran->tim->name }}</td>
                                <td>{{ $laporan->periode->nama_periode }}</td>
                                <td>{{ $laporan->jenisPembiayaan->nama_pembiayaan }}</td>
                                <td>{{ $laporan->jumlah_digunakan }}</td>
                                <td>{{ $laporan->status }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#laporanModal" data-id="{{ $laporan->id }}">
                                        Edit
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.laporan-keuangan.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Yakin ingin menghapus laporan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="laporanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="laporanForm" method="POST" action="{{ route('admin.laporan-keuangan.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="laporanModalLabel">Tambah Laporan Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <!-- Form fields here... -->
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="laporan_id" id="laporan_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Reset form function
    function resetForm() {
        document.getElementById('laporanForm').reset();
        document.getElementById('method').value = 'POST';
        document.getElementById('laporan_id').value = '';
        document.getElementById('laporanModalLabel').innerText = 'Tambah Laporan Keuangan';
    }

    // Modal show event for editing
    $('#laporanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        // Fetch data laporan based on ID
        if (id) {
            fetch('/admin/laporan-keuangan/' + id + '/edit')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('anggaran_id').value = data.anggaran_id;
                    document.getElementById('periode_id').value = data.periode_id;
                    document.getElementById('jenis_pembiayaan_id').value = data.jenis_pembiayaan_id;
                    document.getElementById('jumlah_digunakan').value = data.jumlah_digunakan;
                    document.getElementById('status').value = data.status;
                    document.getElementById('method').value = 'PUT';
                    document.getElementById('laporan_id').value = id;
                    document.getElementById('laporanModalLabel').innerText = 'Edit Laporan Keuangan';
                });
        } else {
            resetForm();
        }
    });
</script>
@endsection
