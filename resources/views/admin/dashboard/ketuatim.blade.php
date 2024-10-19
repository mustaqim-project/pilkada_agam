@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <h1>Dashboard Kanvasing</h1>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-header">Total Kanvasing</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalKanvasing }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-header">Kanvasing Mingguan</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $kanvasingMingguan }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-header">Kanvasing Harian</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $kanvasingHarian }}</h5>
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
