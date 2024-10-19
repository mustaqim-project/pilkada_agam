@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Dashboard') }}</h1>
        </div>
        <div class="row">




            @foreach ($counts as $model => $count)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ ucfirst($model) }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $count }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach




            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2>Chart Kanvasing Harian</h2>
                <canvas id="kanvasingHarianChart"></canvas>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2>Kanvasing Mingguan</h2>
                <canvas id="kanvasingMingguanChart"></canvas>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2>Kanvasing Bulanan</h2>
                <canvas id="kanvasingBulananChart"></canvas>
            </div>
            <div class="section-header">
                <h1>{{ __('admin.Jumlah Kanvasing berdasarkan Lokasi') }}</h1>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Wilayah</th>
                        <th>Nama Kecamatan</th>
                        <th>Nama Kelurahan</th>
                        <th>Total Kanvasing</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kanvasingPerLokasi as $lokasi)
                        <tr>
                            <td>{{ $lokasi->nama_wilayah }}</td>
                            <td>{{ $lokasi->nama_kecamatan }}</td>
                            <td>{{ $lokasi->nama_kelurahan }}</td>
                            <td>{{ $lokasi->total_kanvasing }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="section-header">
                <h1>{{ __('admin.Jumlah Kanvasing berdasarkan Wilayah') }}</h1>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Wilayah</th>
                        <th>Jumlah Kanvasing</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kanvasingPerWilayah as $wilayah)
                        <tr>
                            <td>{{ $wilayah->nama_wilayah }}</td>
                            <td>{{ $wilayah->jumlah_kanvasing }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <script>
        // Data untuk chart Kanvasing Harian
        const kanvasingHarianData = {
            labels: {!! json_encode($kanvasingHarian->keys()) !!},
            datasets: [{
                label: 'Total Kanvasing',
                data: {!! json_encode($kanvasingHarian->values()) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const kanvasingHarianChart = new Chart(document.getElementById('kanvasingHarianChart'), {
            type: 'line',
            data: kanvasingHarianData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data untuk chart Kanvasing Mingguan
        const kanvasingMingguanData = {
            labels: {!! json_encode($kanvasingMingguan->keys()) !!},
            datasets: [{
                label: 'Total Kanvasing',
                data: {!! json_encode($kanvasingMingguan->values()) !!},
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        const kanvasingMingguanChart = new Chart(document.getElementById('kanvasingMingguanChart'), {
            type: 'bar',
            data: kanvasingMingguanData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data untuk chart Kanvasing Bulanan
        const kanvasingBulananData = {
            labels: {!! json_encode($kanvasingBulanan->keys()) !!},
            datasets: [{
                label: 'Total Kanvasing',
                data: {!! json_encode($kanvasingBulanan->values()) !!},
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        };

        const kanvasingBulananChart = new Chart(document.getElementById('kanvasingBulananChart'), {
            type: 'pie',
            data: kanvasingBulananData,
            options: {
                responsive: true,
            }
        });
    </script>
@endsection
