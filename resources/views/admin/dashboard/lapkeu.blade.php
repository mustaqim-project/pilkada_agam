@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Keuangan</h1>
        </div>

        <div class="row mb-4">
            <!-- Total Anggaran Keseluruhan -->
            <div class="col-md-4">
                <h3>Total Anggaran Keseluruhan</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Total Anggaran</th>
                        <td>Rp {{ number_format($totalAnggaranKeseluruhan->total_anggaran_keseluruhan, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <!-- Total Anggaran per Tim -->
            <div class="col-md-4">
                <h3>Total Anggaran per Tim</h3>
                <canvas id="totalAnggaranPerTimChart" class="w-100"></canvas>
            </div>

            <!-- Total Anggaran yang Sudah Dikeluarkan per Tim -->
            <div class="col-md-4">
                <h3>Total Anggaran Digunakan per Tim</h3>
                <canvas id="totalAnggaranDigunakanPerTimChart" class="w-100"></canvas>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Sisa Anggaran per Tim -->
            <div class="col-md-12">
                <h3>Sisa Anggaran per Tim</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tim</th>
                            <th>Total Anggaran</th>
                            <th>Total Digunakan</th>
                            <th>Sisa Anggaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sisaAnggaranPerTim as $tim)
                            <tr>
                                <td>{{ $tim->tim }}</td>
                                <td>Rp {{ number_format($tim->total_anggaran, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($tim->total_anggaran_digunakan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($tim->sisa_anggaran, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Penggunaan Anggaran per Jenis Pembiayaan -->

        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h3>Penggunaan Anggaran per Jenis Pembiayaan</h3>
                <canvas id="penggunaanPerJenisPembiayaanChart" class="w-100"></canvas>
            </div>

            <!-- Penggunaan Anggaran per Periode -->
            <div class="col-md-6">
                <h3>Penggunaan Anggaran per Periode</h3>
                <canvas id="penggunaanPeriodeChart" class="w-100"></canvas>
            </div>
        </div>



        <div class="row mb-4">
            <!-- Status Pembayaran -->
            <div class="col-md-12">
                <h3>Status Pembayaran</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tim</th>
                            <th>Periode</th>
                            <th>Rincian</th>
                            <th>Jumlah Digunakan</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statusPembayaran as $pembayaran)
                            <tr>
                                <td>{{ $pembayaran->tim }}</td>
                                <td>{{ $pembayaran->nama_periode }}</td>
                                <td>{{ $pembayaran->nama_rincian }}</td>
                                <td>Rp {{ number_format($pembayaran->jumlah_digunakan, 0, ',', '.') }}</td>
                                <td>
                                    @if ($pembayaran->status_pembayaran == 1)
                                        Lunas
                                    @elseif($pembayaran->status_pembayaran == 0)
                                        Belum Dibayar
                                    @else
                                        Status Tidak Diketahui
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Rekapitulasi Anggaran Terpakai dan Sisa Anggaran -->
            <div class="col-md-6">
                <h3>Rekapitulasi Anggaran Terpakai dan Sisa Anggaran</h3>
                <canvas id="rekapitulasiAnggaranChart" class="w-100"></canvas>
            </div>

            <!-- Penggunaan Anggaran per Pembiayaan Detail -->
            <div class="col-md-6">
                <h3>Penggunaan Anggaran per Pembiayaan Detail</h3>
                <canvas id="penggunaanPerPembiayaanDetailChart" class="w-100"></canvas>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Anggaran Digunakan vs Total Anggaran per Tim -->
            <div class="col-md-12">
                <h3>Anggaran Digunakan vs Total Anggaran per Tim</h3>
                <canvas id="anggaranDigunakanVsTotalChart" class="w-100"></canvas>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Laporan Pembayaran Lengkap -->
            <div class="col-md-12">
                <h3>Laporan Pembayaran Lengkap</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tim</th>
                            <th>Periode</th>
                            <th>Rincian</th>
                            <th>Jumlah Digunakan</th>
                            <th>Status Pembayaran</th>
                            <th>Bukti Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporanPembayaran as $laporan)
                            <tr>
                                <td>{{ $laporan->tim }}</td>
                                <td>{{ $laporan->nama_periode }}</td>
                                <td>{{ $laporan->nama_rincian }}</td>
                                <td>Rp {{ number_format($laporan->jumlah_digunakan, 0, ',', '.') }}</td>
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
                                        <a href="{{ asset($laporan->bukti_pembayaran) }}" target="_blank">Download</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <script src="{{ asset('admin/assets/modules/chart.min.js') }}"></script>

    <script>
        function formatRupiah(angka) {
            const rupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
            return rupiah;
        }

        // Script untuk Chart.js
        const totalAnggaranPerTimCtx = document.getElementById('totalAnggaranPerTimChart').getContext('2d');
        const totalAnggaranDigunakanPerTimCtx = document.getElementById('totalAnggaranDigunakanPerTimChart').getContext(
            '2d');
        const penggunaanPerJenisPembiayaanCtx = document.getElementById('penggunaanPerJenisPembiayaanChart').getContext(
            '2d');
        const penggunaanPeriodeCtx = document.getElementById('penggunaanPeriodeChart').getContext('2d');
        const rekapitulasiAnggaranCtx = document.getElementById('rekapitulasiAnggaranChart').getContext('2d');
        const penggunaanPerPembiayaanDetailCtx = document.getElementById('penggunaanPerPembiayaanDetailChart').getContext(
            '2d');
        const anggaranDigunakanVsTotalCtx = document.getElementById('anggaranDigunakanVsTotalChart').getContext('2d');

        // Contoh data untuk chart (sesuaikan dengan data dari backend)
        const totalAnggaranPerTimData = {
            labels: {!! json_encode($totalAnggaranPerTim->pluck('tim')) !!},
            datasets: [{
                label: 'Total Anggaran per Tim',
                data: {!! json_encode($totalAnggaranPerTim->pluck('total_anggaran')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const totalAnggaranDigunakanPerTimData = {
            labels: {!! json_encode($totalAnggaranDigunakanPerTim->pluck('tim')) !!},
            datasets: [{
                label: 'Total Anggaran Digunakan per Tim',
                data: {!! json_encode($totalAnggaranDigunakanPerTim->pluck('total_anggaran_digunakan')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Chart untuk Total Anggaran per Tim
        new Chart(totalAnggaranPerTimCtx, {
            type: 'pie',
            data: totalAnggaranPerTimData,
        });

        // Chart untuk Total Anggaran Digunakan per Tim
        new Chart(totalAnggaranDigunakanPerTimCtx, {
            type: 'bar',
            data: totalAnggaranDigunakanPerTimData,
        });

        // Chart untuk Penggunaan Anggaran per Jenis Pembiayaan
        new Chart(penggunaanPerJenisPembiayaanCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($penggunaanPerJenisPembiayaan->pluck('nama_pembiayaan')) !!},
                datasets: [{
                    label: 'Penggunaan per Jenis Pembiayaan',
                    data: {!! json_encode($penggunaanPerJenisPembiayaan->pluck('jumlah')) !!},
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                }]
            }
        });

        // // Chart untuk Penggunaan Anggaran per Periode
        // new Chart(penggunaanPeriodeCtx, {
        //     type: 'line',
        //     data: {
        //         labels: {!! json_encode($penggunaanPeriode->pluck('nama_periode')) !!},
        //         datasets: [{
        //             label: 'Penggunaan per Periode',
        //             data: {!! json_encode($penggunaanPeriode->pluck('total_digunakan')) !!},
        //             fill: false,
        //             borderColor: 'rgb(75, 192, 192)',
        //             tension: 0.1
        //         }]
        //     }
        // });

        new Chart(penggunaanPeriodeCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($penggunaanPeriode->pluck('nama_periode')) !!},
                datasets: [{
                    label: 'Penggunaan per Periode',
                    data: {!! json_encode($penggunaanPeriode->pluck('total_digunakan')) !!},
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            // Menggunakan format Rupiah pada sumbu Y
                            callback: function(value, index, values) {
                                return formatRupiah(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            // Menggunakan format Rupiah di tooltip
                            label: function(tooltipItem) {
                                return formatRupiah(tooltipItem.raw);
                            }
                        }
                    }
                }
            }
        }); // Chart untuk Rekapitulasi Anggaran
        new Chart(rekapitulasiAnggaranCtx, {
            type: 'bar',
            data: {
                labels: ['Total Anggaran', 'Total Digunakan', 'Sisa Anggaran'],
                datasets: [{
                    label: 'Rekapitulasi Anggaran',
                    data: [
                        {!! json_encode($rekapitulasiAnggaran->first()->total_anggaran_periode ?? 0) !!},
                        {!! json_encode($rekapitulasiAnggaran->first()->total_digunakan ?? 0) !!},
                        {!! json_encode($rekapitulasiAnggaran->first()->sisa_anggaran ?? 0) !!}
                    ],
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                }]
            }
        });

        // Chart untuk Penggunaan per Pembiayaan Detail
        new Chart(penggunaanPerPembiayaanDetailCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($penggunaanPerPembiayaanDetail->pluck('nama_detail')) !!},
                datasets: [{
                    label: 'Penggunaan per Pembiayaan Detail',
                    data: {!! json_encode($penggunaanPerPembiayaanDetail->pluck('jumlah')) !!},
                    backgroundColor: '#FF6384',
                }]
            }
        });

        // Chart untuk Anggaran Digunakan vs Total
        new Chart(anggaranDigunakanVsTotalCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($anggaranDigunakanVsTotal->pluck('tim')) !!},
                datasets: [{
                    label: 'Anggaran Digunakan',
                    data: {!! json_encode($anggaranDigunakanVsTotal->pluck('total_digunakan')) !!},
                    backgroundColor: '#FF6384',
                }, {
                    label: 'Total Anggaran',
                    data: {!! json_encode($anggaranDigunakanVsTotal->pluck('total_anggaran')) !!},
                    backgroundColor: '#36A2EB',
                }]
            }
        });
    </script>
@endsection
