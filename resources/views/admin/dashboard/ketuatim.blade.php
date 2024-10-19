@extends('admin.layouts.master')

@section('content')
<section class="section">
    <h2>Kanvasing Harian Berdasarkan Wilayah</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Wilayah</th>
                    <th>Total Kanvasing</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kanvasingWilayah as $data)
                    <tr>
                        <td>{{ $data->nama_wilayah }}</td>
                        <td>{{ $data->total_kanvasing }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Kanvasing Harian Berdasarkan Kecamatan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kecamatan</th>
                    <th>Total Kanvasing</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kanvasingKecamatan as $data)
                    <tr>
                        <td>{{ $data->nama_kecamatan }}</td>
                        <td>{{ $data->total_kanvasing }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Kanvasing Harian Berdasarkan Kelurahan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kelurahan</th>
                    <th>Total Kanvasing</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kanvasingKelurahan as $data)
                    <tr>
                        <td>{{ $data->nama_kelurahan }}</td>
                        <td>{{ $data->total_kanvasing }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>


    <canvas id="kanvasingWilayahChart"></canvas>

    <script>
        var ctx = document.getElementById('kanvasingWilayahChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($kanvasingWilayah->pluck('nama_wilayah')),
                datasets: [{
                    label: 'Total Kanvasing',
                    data: @json($kanvasingWilayah->pluck('total_kanvasing')),
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
    </script>
@endsection
