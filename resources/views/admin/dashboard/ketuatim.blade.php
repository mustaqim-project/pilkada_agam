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
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kanvasing Mingguan</h4>
                            </div>
                            <div class="card-body">
                                {{ $kanvasingMingguan }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kanvasing Harian</h4>
                            </div>
                            <div class="card-body">
                                {{ $kanvasingHarian }}
                            </div>
                        </div>
                    </div>
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

            <h2>Chart Kanvasing per Wilayah</h2>
            <canvas id="kanvasingChart"></canvas>
        </div>
        <script>
            var ctx = document.getElementById('kanvasingChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($kanvasingPerLokasi->pluck('nama_kelurahan')),
                    datasets: [{
                        label: 'Total Kanvasing',
                        data: @json($kanvasingPerLokasi->pluck('total_kanvasing')),
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
        </script>
    </section>
@endsection
