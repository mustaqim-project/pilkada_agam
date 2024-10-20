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
                                                                            @if ($laporan->tujuan_pembayaran)
                                                                                <!-- Cek jika laporan_pembayaran tidak null -->
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

                                                                                        <a href="#" data-toggle="modal"
                                                                                        data-target="#editModal{{ $laporan->penggunaan_anggaran_id }}"
                                                                                        class="btn btn-warning">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </a>
                                                                                    <a href="{{ route('admin.keuangan.LaporanPembayaran.destroy', $laporan->penggunaan_anggaran_id) }}"
                                                                                        class="btn btn-danger delete-item">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                    </a>

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
