@extends('mobile.frontend.layout.master')

@section('content')


<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}"><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>


    <!-- Chart -->
    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Top 3 Kecamatan dengan Jumlah Pemilih Tertinggi</h3>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="chartKabupatenSetuju"></canvas>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Top 3 Kelurahan dengan Jumlah Pemilih Tertinggi</h3>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="chartKecamatanSetuju"></canvas>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Top 3 Kecamatan dengan Popularitas Tertinggi</h3>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="chartPopularitasKabupaten"></canvas>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Top 3 Kelurahan dengan Popularitas Tertinggi</h3>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="chartPopularitasKecamatan"></canvas>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Top 3 Kecamatan dengan Jumlah Pemilih Ragu-Ragu Tertinggi</h3>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="chartKabupatenRaguRagu"></canvas>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Top 3 Kelurahan dengan Jumlah Pemilih Ragu-Ragu Tertinggi</h3>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="chartKecamatanRaguRagu"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        let charts = [];

        function loadJS(url, callback) {
            var scriptTag = document.createElement('script');
            scriptTag.src = url;
            scriptTag.onload = callback;
            scriptTag.onreadystatechange = callback;
            document.body.appendChild(scriptTag);
        }

        function createChart(chartId, labels, datasetLabel, data, backgroundColor) {
            let ctx = document.getElementById(chartId).getContext('2d');
            let chartInstance = new Chart(ctx, {
                type: 'bar'
                , data: {
                    labels: labels
                    , datasets: [{
                        label: datasetLabel
                        , backgroundColor: backgroundColor
                        , data: data
                    }]
                }
                , options: {
                    responsive: true
                    , maintainAspectRatio: false
                    , scales: {
                        y: {
                            beginAtZero: true
                            , title: {
                                display: true
                                , text: 'Jumlah'
                            }
                        }
                        , x: {
                            title: {
                                display: true
                                , text: 'Wilayah'
                            }
                        }
                    }
                    , plugins: {
                        legend: {
                            display: true
                            , position: 'bottom'
                        }
                    }
                }
            });
            charts.push(chartInstance);
        }

        $.ajax({
            url: "{{ route('get-strength') }}"
            , method: 'GET'
            , success: function(response) {
                // Destroy previous charts if they exist
                charts.forEach(chart => chart.destroy());

                // Prepare data for each chart
                createChart(
                    'chartKabupatenSetuju'
                    , response.topKabupatenKotaKecamatanSetuju.map(item => item.kecamatan_name)
                    , 'Setuju'
                    , response.topKabupatenKotaKecamatanSetuju.map(item => item.setuju)
                    , '#A0D468'
                );

                createChart(
                    'chartKabupatenRaguRagu'
                    , response.topKabupatenKotaKecamatanRaguRagu.map(item => item.kecamatan_name)
                    , 'Ragu-Ragu'
                    , response.topKabupatenKotaKecamatanRaguRagu.map(item => item.ragu_ragu)
                    , '#FFCE56'
                );

                createChart(
                    'chartKecamatanSetuju'
                    , response.topKecamatanKelurahanSetuju.map(item => item.kelurahan_name)
                    , 'Setuju'
                    , response.topKecamatanKelurahanSetuju.map(item => item.setuju)
                    , '#4A89DC'
                );

                createChart(
                    'chartKecamatanRaguRagu'
                    , response.topKecamatanKelurahanRaguRagu.map(item => item.kelurahan_name)
                    , 'Ragu-Ragu'
                    , response.topKecamatanKelurahanRaguRagu.map(item => item.ragu_ragu)
                    , '#FFCE56'
                );

                createChart(
                    'chartPopularitasKabupaten'
                    , response.topKabupatenKotaKecamatanPopularitasSetuju.map(item => item.kecamatan_name)
                    , 'Popularitas Setuju'
                    , response.topKabupatenKotaKecamatanPopularitasSetuju.map(item => item.setuju)
                    , '#FF6384'
                );

                createChart(
                    'chartPopularitasKecamatan'
                    , response.topKecamatanKelurahanPopularitasSetuju.map(item => item.kelurahan_name)
                    , 'Popularitas Setuju'
                    , response.topKecamatanKelurahanPopularitasSetuju.map(item => item.setuju)
                    , '#36A2EB'
                );
            }
        });

        // Load chart.js script if needed
        loadJS('mobile/scripts/charts.js', function() {});
    });

</script>


@endsection
