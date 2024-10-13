@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Wisata - Data Responden</h1>
        </div>
        <h1>Dashboard Kehadiran</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Hadir</th>
                    <th>Tidak Hadir</th>
                    <th>Persentase Hadir (%)</th>
                    <th>Persentase Tidak Hadir (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($persentaseKehadiran as $data)
                <tr>
                    <td>{{ $data->status == 0 ? 'Booking' : 'Onsite' }}</td>
                    <td>{{ $data->total }}</td>
                    <td>{{ $data->hadir }}</td>
                    <td>{{ $data->tidak_hadir }}</td>
                    <td>{{ number_format($data->persentase_hadir, 2) }}</td>
                    <td>{{ number_format($data->persentase_tidak_hadir, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ array_sum(array_column($persentaseKehadiran, 'total')) }}</th>
                    <th>{{ array_sum(array_column($persentaseKehadiran, 'hadir')) }}</th>
                    <th>{{ array_sum(array_column($persentaseKehadiran, 'tidak_hadir')) }}</th>
                    <th>100.00</th> <!-- Karena total persentase harus 100% -->
                    <th>0.00</th> <!-- Tidak ada persentase tidak hadir -->
                </tr>
            </tfoot>
        </table>
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
