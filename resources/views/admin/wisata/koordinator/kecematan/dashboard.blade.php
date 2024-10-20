@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Wisata - Data Responden</h1>
        </div>

        <div class="row mb-4">
            <!-- Total Responden Berdasarkan Jenis Kelamin -->
            <div class="col-md-6">
                <h3>Total Responden Berdasarkan Jenis Kelamin</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <th>Jumlah Responden</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jumlahRespondenJenisKelamin as $responden)
                            <tr>
                                <td>
                                    @if ($responden->jenis_kelamin == 'L')
                                        Laki - Laki
                                    @elseif ($responden->jenis_kelamin == 'P')
                                        Perempuan
                                    @endif
                                </td>
                                <td>{{ $responden->jumlah_responden }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Distribusi Usia Responden -->
            <div class="col-md-6">
                <h3>Distribusi Usia Responden</h3>
                <canvas id="distribusiUsiaChart" class="w-100"></canvas>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Jumlah Responden Berdasarkan Pekerjaan -->
            <div class="col-md-6">
                <h3>Jumlah Responden Berdasarkan Pekerjaan</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pekerjaan</th>
                            <th>Jumlah Responden</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jumlahRespondenPekerjaan as $pekerjaan)
                            <tr>
                                <td>{{ $pekerjaan->nama_pekerjaan }}</td>
                                <td>{{ $pekerjaan->jumlah_responden }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Jumlah Responden per Kecamatan -->
            <div class="col-md-6">
                <h3>Jumlah Responden per Kecamatan</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kecamatan</th>
                            <th>Jumlah Responden</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jumlahRespondenKecamatan as $kecamatan)
                            <tr>
                                <td>{{ $kecamatan->nama_kecamatan }}</td>
                                <td>{{ $kecamatan->jumlah_responden }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Peta Lokasi Responden -->
            <div class="col-md-12">
                <h3>Peta Lokasi Responden</h3>
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Jumlah Kegiatan Pengguna -->
            <div class="col-md-6">
                <h3>Jumlah Responden Berdasarkan Wilayah</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Wilayah</th>
                            <th>Jumlah Responden</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jumlahRespondenWilayah as $kegiatan)
                            <tr>
                                <td>{{ $kegiatan->nama_wilayah }}</td>
                                <td>{{ $kegiatan->jumlah_responden }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Jumlah Responden per Hari -->
            <div class="col-md-6">
                <h3>Jumlah Responden per Hari</h3>
                <canvas id="respondenPerHariChart" class="w-100"></canvas>
            </div>
        </div>

        <div class="row mb-4">


             <!-- Penggunaan APK -->
             <div class="col-md-6">
                <h3>Penggunaan Brosur, Stiker, dan Kartu Coblos</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis APK</th>
                            <th>Total Penggunaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Brosur</td>
                            <td>{{ $jumlahPenggunaanPromosi->total_brosur }}</td>
                        </tr>
                        <tr>
                            <td>Stiker</td>
                            <td>{{ $jumlahPenggunaanPromosi->total_stiker }}</td>
                        </tr>
                        <tr>
                            <td>Kartu Coblos</td>
                            <td>{{ $jumlahPenggunaanPromosi->total_kartu_coblos }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Rata-rata Responden per User -->
            <div class="col-md-6">
                <h3>Rata-rata Responden per User</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Rata-rata Responden</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rataRataRespondenPerUser as $responden)
                            <tr>
                                <td>{{ $responden->user->name }}</td>
                                <td>{{ $responden->rata_rata_responden }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>

    <!-- Scripts untuk menampilkan chart menggunakan Chart.js -->
    <script src="{{ asset('admin/assets/modules/chart.min.js') }}"></script>

    <script>
        // Chart untuk distribusi usia
        const distribusiUsiaCtx = document.getElementById('distribusiUsiaChart').getContext('2d');
        const distribusiUsiaChart = new Chart(distribusiUsiaCtx, {
            type: 'bar',
            data: {
                labels: @json($distribusiUsia->pluck('usia')),
                datasets: [{
                    label: 'Jumlah Responden',
                    data: @json($distribusiUsia->pluck('jumlah_responden')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }]
            },
        });

        // Chart untuk jumlah responden per hari
        const respondenPerHariCtx = document.getElementById('respondenPerHariChart').getContext('2d');
        const respondenPerHariChart = new Chart(respondenPerHariCtx, {
            type: 'line',
            data: {
                labels: @json($jumlahRespondenPerHari->pluck('tanggal')),
                datasets: [{
                    label: 'Jumlah Responden',
                    data: @json($jumlahRespondenPerHari->pluck('jumlah_responden')),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false,
                }]
            },
        });
    </script>
@endsection
