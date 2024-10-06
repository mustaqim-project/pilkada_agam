@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h2>Laporan Keuangan</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#laporanModal" onclick="resetForm()">Tambah Laporan Keuangan</button>

    <table class="table">
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
                    <td>{{ $laporan->periode->name }}</td>
                    <td>{{ $laporan->jenisPembiayaan->nama_pembiayaan }}</td>
                    <td>{{ $laporan->jumlah_digunakan }}</td>
                    <td>{{ $laporan->status }}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editLaporan({{ $laporan->id }})">Edit</button>
                        <form action="{{ route('admin.laporan-keuangan.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

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
                    <div class="form-group">
                        <label for="anggaran_id">Anggaran</label>
                        <select name="anggaran_id" id="anggaran_id" class="form-control" required>
                            @foreach ($anggarans as $anggaran)
                                    <option value="{{ $anggaran->id }}">
                                        {{ $anggaran->tim ? $anggaran->tim->name : 'Tim tidak ditemukan' }} -
                                        Rp {{ number_format($anggaran->total_anggaran, 2, ',', '.') }}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="periode_id">Periode</label>
                        <select name="periode_id" id="periode_id" class="form-control" required>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}">{{ $periode->nama_periode }} -  Rp {{ number_format($periode->anggaran_periode, 2, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pembiayaan_id">Jenis Pembiayaan</label>
                        <select name="jenis_pembiayaan_id" id="jenis_pembiayaan_id" class="form-control" required>
                            @foreach($jenisPembiayaans as $jenisPembiayaan)
                                <option value="{{ $jenisPembiayaan->id }}">{{ $jenisPembiayaan->nama_pembiayaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_digunakan">Jumlah Digunakan</label>
                        <input type="number" name="jumlah_digunakan" id="jumlah_digunakan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="status">Status Pembayaran</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Pilih Status Pembayaran</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>

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
    function resetForm() {
        document.getElementById('laporanForm').reset();
        document.getElementById('method').value = 'POST';
        document.getElementById('laporan_id').value = '';
        document.getElementById('laporanModalLabel').innerText = 'Tambah Laporan Keuangan';
    }

    function editLaporan(id) {
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
                var myModal = new bootstrap.Modal(document.getElementById('laporanModal'));
                myModal.show();
            });
    }
</script>
@endsection
@endsection
