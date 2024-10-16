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


        </div>





        {{-- <div class="row mb-4">
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
        </div> --}}
        <div class="row mb-4">
            <!-- Laporan Pembayaran Lengkap dalam Bentuk Tabel -->
            <div class="col-md-12">
                <h3>Laporan Pembayaran Lengkap</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Tim</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporanPembayaran as $tim => $periodes)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tim }}</td>
                                <td>
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTim{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapseTim{{ $loop->iteration }}">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Subtabel Periode dan Detail untuk Tim -->
                            <tr id="collapseTim{{ $loop->iteration }}" class="collapse">
                                <td colspan="3">
                                    <table class="table table-bordered">
                                        @foreach ($periodes as $periode => $details)
                                            <thead>
                                                <tr>
                                                    <th colspan="4">Periode: {{ $periode }}</th>
                                                </tr>
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



        // Data dari PHP ke dalam JavaScript
        const labels = {!! json_encode($labels) !!};
        const data = {!! json_encode($data) !!};

        // Chart.js Pie Chart
        const totalAnggaranPerTimData = {
            labels: labels, // Nama tim dari PHP
            datasets: [{
                label: 'Total Anggaran',
                data: data, // Total anggaran dari PHP
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)', // Merah
                    'rgba(54, 162, 235, 0.6)', // Biru
                    'rgba(255, 206, 86, 0.6)' // Kuning
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Membuat Pie Chart
        new Chart(totalAnggaranPerTimCtx, {
            type: 'pie',
            data: totalAnggaranPerTimData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                // Format angka sebagai Rupiah
                                return context.label + ': ' + new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });

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


    </script>
@endsection
