@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Keuangan</h1>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>Laporan Pembayaran</h3>
                <h3>Total : Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                </h3>

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
                            <!-- Subtabel Periode dan Detail untuk Tim -->
                            <tr id="collapseTim{{ $loop->iteration }}" class="collapse">
                                <td colspan="3">
                                    <table class="table table-bordered">
                                        @foreach ($periodes as $periode => $details)
                                            <thead>
                                                @php
                                                // Mencari jumlah untuk periode ini
                                                $jumlahPeriode = $jumlahPerPeriode->firstWhere('nama_periode', $periode);
                                                $totalPeriode = $jumlahPeriode ? $jumlahPeriode->total_jumlah : 0;
                                            @endphp
                                            <th colspan="4">Periode: {{ $periode }} (Total: Rp {{ number_format($totalPeriode, 0, ',', '.') }})</th>
                                                <tr>
                                                    <th>Rincian</th>
                                                    <th>Jumlah Digunakan</th>
                                                    <th>Status Pembayaran</th>
                                                    <th>Bukti Pembayaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($details as $laporan)
                                                    <tr>
                                                        <td>{{ $laporan->nama_rincian }}</td>
                                                        <td>Rp {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            @if ($laporan->status_pembayaran == 1)
                                                                Lunas
                                                            @elseif($laporan->status_pembayaran == 0)
                                                                Belum Dibayar
                                                            @else
                                                                Status Tidak Diketahui
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($laporan->bukti_pembayaran)
                                                                <a href="{{ asset($laporan->bukti_pembayaran) }}"
                                                                    target="_blank">Download</a>
                                                            @else
                                                                -
                                                            @endif
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

    </section>
@endsection
