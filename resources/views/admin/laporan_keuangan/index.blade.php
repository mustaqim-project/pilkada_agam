@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Laporan Keuangan') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-header-actions">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#laporanModal" onclick="resetForm()">
                        <i class="fas fa-plus"></i> {{ __('admin.Create new') }}
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableLapKeu">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Anggaran</th>
                                <th>Periode</th>
                                <th>Jenis Pembiayaan</th>
                                <th>Jumlah Digunakan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanKeuangan as $laporan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $laporan->anggaran->tim->name }}</td>
                                    <td>{{ $laporan->periode->nama_periode }}</td>
                                    <td>{{ $laporan->jenisPembiayaan->nama_pembiayaan }}</td>
                                    <td>Rp {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}</td>
                                    <td>{{ $laporan->keterangan }}</td>
                                    <td>{{ $laporan->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" onclick="editLaporan({{ $laporan->id }})">Edit</button>
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

    <!-- Modal Tambah/Edit Laporan Keuangan -->
    <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="laporanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="laporanForm" method="POST" action="{{ route('admin.laporan-keuangan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="laporan_id" id="laporan_id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="laporanModalLabel">Tambah Laporan Keuangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="anggaran_id">Anggaran</label>
                            <select name="anggaran_id" id="anggaran_id" class="form-control" required>
                                @foreach ($anggarans as $anggaran)
                                    <option value="{{ $anggaran->id }}">
                                        {{ $anggaran->tim ? $anggaran->tim->name : 'Tim tidak ditemukan' }} - Rp {{ number_format($anggaran->total_anggaran, 2, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="periode_id">Periode</label>
                            <select name="periode_id" id="periode_id" class="form-control" required>
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }} - Rp {{ number_format($periode->anggaran_periode, 2, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenis_pembiayaan_id">Jenis Pembiayaan</label>
                            <select name="jenis_pembiayaan_id" id="jenis_pembiayaan_id" class="form-control" required>
                                @foreach ($jenisPembiayaans as $jenisPembiayaan)
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#tableLapKeu").DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [6] // Mengatur agar kolom aksi tidak bisa disortir
                }],
                "order": [
                    [0, 'asc'] // Mengurutkan berdasarkan No
                ]
            });
        });

        window.resetForm = function() {
            $('#laporanForm')[0].reset();
            $('#method').val('POST');
            $('#laporan_id').val('');
            $('#laporanForm').attr('action', '{{ route('admin.laporan-keuangan.store') }}');
            $('#laporanModalLabel').text('Tambah Laporan Keuangan');
        };

        window.editLaporan = function(id) {
            fetch('/admin/laporan-keuangan/' + id + '/edit')
                .then(response => response.json())
                .then(data => {
                    $('#anggaran_id').val(data.anggaran_id);
                    $('#periode_id').val(data.periode_id);
                    $('#jenis_pembiayaan_id').val(data.jenis_pembiayaan_id);
                    $('#jumlah_digunakan').val(data.jumlah_digunakan);
                    $('#keterangan').val(data.keterangan);
                    $('#status').val(data.status);

                    $('#laporanForm').attr('action', '/admin/laporan-keuangan/' + id);
                    $('#method').val('PUT');
                    $('#laporan_id').val(id);
                    $('#laporanModalLabel').text('Edit Laporan Keuangan');
                    $('#laporanModal').modal('show');
                });
        };
    </script>
@endsection
