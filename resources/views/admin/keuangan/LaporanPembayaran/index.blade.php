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
                                                            <td>Rp
                                                                {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}
                                                            </td>
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
                                                                            {{ dd($laporan) }}
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>{{ $laporan->tujuan_pembayaran }}
                                                                                    </td>
                                                                                    <td>Rp
                                                                                        {{ number_format($laporan->nominal, 0, ',', '.') }}
                                                                                    </td>

                                                                                    <td>{{ $laporan->tanggal_pembayaran ? \Carbon\Carbon::parse($laporan->tanggal_pembayaran)->format('d/m/Y') : '-' }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($laporan->bukti_pembayaran_laporan)
                                                                                            <a href="{{ asset($laporan->bukti_pembayaran_laporan) }}"
                                                                                                target="_blank">Download</a>
                                                                                        @else
                                                                                            -
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>

                                                                                        <a href="#"
                                                                                            data-toggle="modal"
                                                                                            data-target="#editModal{{ $laporan->id }}"
                                                                                            class="btn btn-warning">
                                                                                            <i class="fas fa-edit"></i>
                                                                                        </a>
                                                                                        <a href="{{ route('admin.keuangan.LaporanPembayaran.destroy', $laporan->id) }}"
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
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.keuangan.penggunaan_anggaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Penggunaan Anggaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="detail_pembiayaan_id">Nama Rincian Pembiayaan</label>
                            <select class="form-control" name="detail_pembiayaan_id" required>
                                @foreach ($laporanPembayaran as $tim => $periodes)
                                    @foreach ($periodes as $detail)
                                        @foreach ($detail->laporan as $laporan)
                                            <option value="{{ $laporan->id }}">
                                                {{ $laporan->nama_rincian }} - Rp {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tujuan_pembayaran">Tujuan Pembayaran</label>
                            <input type="text" class="form-control" name="tujuan_pembayaran" required maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="nominal">Jumlah Pembayaran</label>
                            <input type="number" class="form-control" name="nominal" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran" required>
                        </div>
                        <div class="form-group">
                            <label for="bukti_pembayaran">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.gif,.webp">
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



    {{-- Modal Edit --}}
    @foreach ($laporanPembayaran as $tim => $periodes)
        @foreach ($periodes as $periode => $details)
            @foreach ($details as $laporan)
                <div class="modal fade" id="editModal{{ $laporan->penggunaan_anggaran_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel{{ $laporan->penggunaan_anggaran_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <form
                                action="{{ route('admin.keuangan.penggunaan_anggaran.update', $laporan->penggunaan_anggaran_id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $laporan->penggunaan_anggaran_id }}">
                                        Edit Penggunaan Anggaran
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="periode_id">Nama Periode</label>
                                        <select class="form-control" name="periode_id" required>
                                            <option value="{{ $laporan->nama_periode }}" selected>
                                                {{ $laporan->nama_periode }}
                                            </option>
                                            @foreach ($dataPeriode as $periode)
                                                <option value="{{ $periode->id }}">
                                                    {{ $periode->nama_periode }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="detail_pembiayaan_id">Nama Rincian Pembiayaan</label>
                                        <select class="form-control" name="detail_pembiayaan_id" required>
                                            @foreach ($datadetailPembiayaans as $detail)
                                                <option value="{{ $detail->id }}"
                                                    {{ $detail->nama_rincian == $laporan->nama_rincian ? 'selected' : '' }}>
                                                    {{ $detail->nama_rincian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="jumlah_digunakan">Jumlah Digunakan</label>
                                        <input type="number" class="form-control" name="jumlah_digunakan"
                                            value="{{ $laporan->jumlah_digunakan }}" required>
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
        @endforeach
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
