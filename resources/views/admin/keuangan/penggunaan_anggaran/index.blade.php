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

            <div class="row mb-4">
                <div class="col-md-12">
                    <h3>Penggunaan Anggaran</h3>
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
                                                                <button class="btn btn-sm btn-info" type="button"
                                                                    data-toggle="collapse"
                                                                    data-target="#collapseDetail{{ $loop->parent->iteration }}_{{ $loop->iteration }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseDetail{{ $loop->parent->iteration }}_{{ $loop->iteration }}">
                                                                    Lihat Pembayaran
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <tr id="collapseDetail{{ $loop->parent->iteration }}_{{ $loop->iteration }}"
                                                            class="collapse">
                                                            <td colspan="5">
                                                                <table class="table table-sm table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Keterangan Penggunaan</th>
                                                                            <th>Nominal Penggunaan</th>
                                                                            <th>Bukti Pembayaran</th>
                                                                            <th>Tanggal Pembayaran</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($details as $laporan)
                                                                            @if ($laporan->tujuan_pembayaran)
                                                                                <!-- Cek jika laporan_pembayaran tidak null -->
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>{{ $laporan->tujuan_pembayaran }}
                                                                                    </td>
                                                                                    <td>Rp
                                                                                        {{ number_format($laporan->nominal, 0, ',', '.') }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($laporan->bukti_pembayaran_laporan)
                                                                                            <a href="{{ asset($laporan->bukti_pembayaran_laporan) }}"
                                                                                                target="_blank">Download</a>
                                                                                        @else
                                                                                            -
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>{{ $laporan->tanggal_pembayaran ? \Carbon\Carbon::parse($laporan->tanggal_pembayaran)->format('d/m/Y') : '-' }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
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
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.keuangan.penggunaan_anggaran.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Penggunaan Anggaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="form-group">
                            <label for="periode_id">Nama Periode</label>
                            <select class="form-control" name="periode_id" required>
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }} -
                                        {{ $periode->anggaran->tim->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="periode_id">Nama Periode</label>
                            <select class="form-control" name="periode_id" required>
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">
                                        {{ $periode->nama_periode }} -
                                        {{ $periode->anggaran->first()->tim->name ?? 'Tidak ada tim' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail_pembiayaan_id">Nama Rincian Pembiayaan</label>
                            <select class="form-control" name="detail_pembiayaan_id" required>
                                @foreach ($detailPembiayaans as $detail)
                                    <option value="{{ $detail->id }}">{{ $detail->nama_rincian }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_digunakan">Jumlah Anggaran</label>
                            <input type="number" class="form-control" name="jumlah_digunakan" required>
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

    {{-- Modal Edit --}}
    @foreach ($penggunaanAnggaran as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.keuangan.penggunaan_anggaran.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
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
                                <label for="periode_id">Nama Periode</label>
                                <select class="form-control" name="periode_id" required>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode->id }}"
                                            {{ $periode->id == $item->periode_id ? 'selected' : '' }}>
                                            {{ $periode->nama_periode }} - {{ $periode->anggaran->tim->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="detail_pembiayaan_id">Nama Rincian Pembiayaan</label>
                                <select class="form-control" name="detail_pembiayaan_id" required>
                                    @foreach ($detailPembiayaans as $detail)
                                        <option value="{{ $detail->id }}"
                                            {{ $detail->id == $item->detail_pembiayaan_id ? 'selected' : '' }}>
                                            {{ $detail->nama_rincian }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_digunakan">Jumlah Anggaran</label>
                                <input type="number" class="form-control" name="jumlah_digunakan"
                                    value="{{ $item->jumlah_digunakan }}" required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan">{{ $item->keterangan }}</textarea>
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
