@extends('admin.layouts.master')

@section('content')
    <section class="section">

        <div class="section-header">
            <h1>{{ __('admin.Dashboard Kanvasing') }}</h1>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kanvasing</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalKanvasing }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2>Chart Kanvasing Harian</h2>
                <canvas id="kanvasingHarianChart"></canvas>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2>Chart Kanvasing Mingguan</h2>
                <canvas id="kanvasingMingguanChart"></canvas>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2>Chart Kanvasing Bulanan</h2>
                <canvas id="kanvasingBulananChart"></canvas>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2>Chart Kanvasing per Wilayah</h2>
                <canvas id="kanvasingWilayahChart"></canvas>
            </div>




            <h2>Jumlah Kanvasing per Wilayah, Kecamatan, dan Kelurahan</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Wilayah</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Total Kanvasing</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kanvasingPerLokasi as $data)
                        <tr>
                            <td>{{ $data->nama_wilayah }}</td>
                            <td>{{ $data->nama_kecamatan }}</td>
                            <td>{{ $data->nama_kelurahan }}</td>
                            <td>{{ $data->total_kanvasing }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        <script>
            // Chart Kanvasing Harian
            var ctxHarian = document.getElementById('kanvasingHarianChart').getContext('2d');
            var chartHarian = new Chart(ctxHarian, {
                type: 'line',
                data: {
                    labels: @json(
                        $kanvasingHarian->map(function ($item) {
                            return $item->date . ' ' . $item->hour . ':00';
                        })),
                    datasets: [{
                        label: 'Total Kanvasing Harian',
                        data: @json($kanvasingHarian->pluck('total')),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart Kanvasing Mingguan
            var ctxMingguan = document.getElementById('kanvasingMingguanChart').getContext('2d');
            var chartMingguan = new Chart(ctxMingguan, {
                type: 'bar',
                data: {
                    labels: @json($kanvasingMingguan->pluck('date')),
                    datasets: [{
                        label: 'Total Kanvasing Mingguan',
                        data: @json($kanvasingMingguan->pluck('total')),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart Kanvasing Bulanan
            var ctxBulanan = document.getElementById('kanvasingBulananChart').getContext('2d');
            var chartBulanan = new Chart(ctxBulanan, {
                type: 'bar',
                data: {
                    labels: @json($kanvasingBulanan->pluck('month')),
                    datasets: [{
                        label: 'Total Kanvasing Bulanan',
                        data: @json($kanvasingBulanan->pluck('total')),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart Kanvasing per Wilayah (Pie Chart)
            var ctxWilayah = document.getElementById('kanvasingWilayahChart').getContext('2d');
            var chartWilayah = new Chart(ctxWilayah, {
                type: 'pie',
                data: {
                    labels: @json($kanvasingPerWilayah->pluck('nama_wilayah')),
                    datasets: [{
                        label: 'Total Kanvasing per Wilayah',
                        data: @json($kanvasingPerWilayah->pluck('jumlah_kanvasing')),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </section>
@endsection
