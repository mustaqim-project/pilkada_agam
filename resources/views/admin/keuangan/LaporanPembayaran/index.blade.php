@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.Daftar Laporan Pembayaran') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-header-actions">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                    + Laporan Pembayaran
                </button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Tim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporanPembayaran as $tim => $periodes)
                            <tr>
                                <td>
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapseTim{{ $loop->iteration }}" aria-expanded="false"
                                        aria-controls="collapseTim{{ $loop->iteration }}">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </td>
                                <td>{{ $tim }}</td>
                            </tr>
                            <!-- Subtabel Periode untuk Tim -->
                            <tr id="collapseTim{{ $loop->iteration }}" class="collapse">
                                <td colspan="2">
                                    <table class="table table-bordered">
                                        @foreach ($periodes as $periode => $details)
                                            <thead>
                                                <tr>
                                                    <th colspan="5">Periode: {{ $periode }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Rincian</th>
                                                    <th>Jumlah Anggaran</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($details as $laporan)
                                                    <tr>
                                                        <td>{{ $laporan->nama_rincian }}</td>
                                                        <td>Rp {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}</td>
                                                        <td>
                                                            <!-- Button untuk membuka dropdown laporan_pembayaran -->
                                                            <button class="btn btn-sm btn-info" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#collapseDetail{{ $loop->parent->iteration }}_{{ $loop->iteration }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapseDetail{{ $loop->parent->iteration }}_{{ $loop->iteration }}">
                                                                Lihat Pembayaran
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Dropdown detail laporan_pembayaran -->
                                                    <tr id="collapseDetail{{ $loop->parent->iteration }}_{{ $loop->iteration }}"
                                                        class="collapse">
                                                        <td colspan="5">
                                                            <table class="table table-sm table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Keterangan Penggunaan</th>
                                                                        <th>Nominal Penggunaan</th>
                                                                        <th>Tanggal Pembayaran</th>
                                                                        <th>Bukti Pembayaran</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($details as $laporan)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $laporan->tujuan_pembayaran }}</td>
                                                                            <td>Rp {{ number_format($laporan->nominal, 0, ',', '.') }}</td>
                                                                            <td>{{ $laporan->tanggal_pembayaran ? \Carbon\Carbon::parse($laporan->tanggal_pembayaran)->format('d/m/Y') : '-' }}</td>
                                                                            <td>
                                                                                @if ($laporan->bukti_pembayaran_laporan)
                                                                                    <a href="{{ asset($laporan->bukti_pembayaran_laporan) }}" target="_blank">Download</a>
                                                                                @else
                                                                                    -
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" data-toggle="modal"
                                                                                    data-target="#editModal{{ $laporan->laporan_id }}"
                                                                                    class="btn btn-warning">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                                <a href="{{ route('admin.keuangan.laporan_pembayaran.destroy', $laporan->laporan_id) }}"
                                                                                    class="btn btn-danger delete-item">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.keuangan.laporan_pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Laporan Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="penggunaan_anggaran_id">Penggunaan Anggaran</label>
                        <select name="penggunaan_anggaran_id" id="penggunaan_anggaran_id" class="form-control">
                            <option value="">-- Pilih Penggunaan Anggaran --</option>
                            @foreach ($laporanPembayaran as $tim => $periodes)
                                @foreach ($periodes as $periode => $details)
                                    @foreach ($details as $laporan)
                                        <option value="{{ $laporan->penggunaan_anggaran_id }}">{{ $laporan->nama_rincian }} - {{ $tim }}</option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tujuan_pembayaran">Tujuan Pembayaran</label>
                        <input type="text" name="tujuan_pembayaran" id="tujuan_pembayaran" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" name="nominal" id="nominal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control-file">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                        <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" required>
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

<!-- Script JavaScript untuk hapus item -->
<script>
    $(document).on('click', '.delete-item', function(e) {
        e.preventDefault();
        if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Refresh halaman setelah hapus
                },
                error: function(xhr) {
                    alert('Gagal menghapus item!');
                }
            });
        }
    });
</script>
@endsection
