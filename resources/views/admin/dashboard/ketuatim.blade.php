@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="summary-box">
            <h3>Total Kanvasing: {{ $totalKanvasing }}</h3>
            <h3>Kanvasing Mingguan: {{ $kanvasingMingguan }}</h3>
            <h3>Kanvasing Harian: {{ $kanvasingHarian }}</h3>
        </div>

        <div class="chart">
            <canvas id="kanvasingChart"></canvas>
        </div>


    </section>


    <script>
        var ctx = document.getElementById('kanvasingChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($kanvasingPerWilayah->pluck('nama_wilayah')),
                datasets: [{
                    label: 'Total Kanvasing',
                    data: @json($kanvasingPerWilayah->pluck('total_kanvasing')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection
