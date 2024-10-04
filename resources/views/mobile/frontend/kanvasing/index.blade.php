@extends('mobile.frontend.layout.master')

@section('content')
<style>
    .table th,
    .table td {
        vertical-align: middle;
    }

    .table th {
        background-color: #03836d; /* Bootstrap primary color */
        color: white; /* White text for table header */
        text-align: center; /* Center align header text */
    }


    .table img {
        border-radius: 5px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .map-container {
        position: relative;
    }

    .total-count-overlay {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(255, 255, 255, 0.8);
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        z-index: 1000;
    }
</style>

<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}"><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>

    @php
    use App\Models\Kanvasing;
    $totalKanvasings = Kanvasing::count();
    @endphp

    <!-- SweetAlert Success -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    <div class="map-container">
        <div id="map" style="display: block; height: 400px;"></div> <!-- Map container -->
        <div class="total-count-overlay">
            Total Kanvasing: <strong>{{ $totalKanvasings }}</strong>
        </div>
    </div>

    <!-- Tabel Daftar Cakada -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Provinsi</th>
                            <th>Kabupaten/Kota</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Nama KK</th>
                            <th>Nomor HP</th>
                            <th>Alamat</th>
                            <th>Elektabilitas</th>
                            <th>Popularitas</th>
                            <th>Jenis Kelamin</th>
                            <th>Usia</th>
                            <th>Jumlah Pemilih</th>
                            <th>Alasan</th>
                            <th>Pesan</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Long</th>
                            <th>Lat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kanvasings as $kanvasing)
                        <tr>
                            <td>{{ $kanvasing->id }}</td>
                            <td>{{ $kanvasing->provinsi_name }}</td>
                            <td>{{ $kanvasing->kabupaten_name }}</td>
                            <td>{{ $kanvasing->kecamatan_name }}</td>
                            <td>{{ $kanvasing->kelurahan_name }}</td>
                            <td>{{ $kanvasing->nama_kk }}</td>
                            <td>{{ $kanvasing->nomor_hp }}</td>
                            <td>{{ $kanvasing->alamat }}</td>
                            <td>{{ $kanvasing->elektabilitas == 1 ? 'Memilih' : ($kanvasing->elektabilitas == 2 ? 'Tidak Memilih' : 'Tidak Diketahui') }}</td>
                            <td>{{ $kanvasing->popularitas == 1 ? 'Kenal' : ($kanvasing->popularitas == 2 ? 'Tidak Kenal' : 'Tidak Diketahui') }}</td>
                            <td>{{ $kanvasing->jenis_kelamin == 1 ? 'Laki-laki' : ($kanvasing->jenis_kelamin == 2 ? 'Perempuan' : 'Tidak Diketahui') }}</td>
                            <td>{{ $kanvasing->usia }}</td>
                            <td>{{ $kanvasing->jum_pemilih }}</td>
                            <td>{{ $kanvasing->alasan }}</td>
                            <td>{{ $kanvasing->pesan }}</td>
                            <td>{{ $kanvasing->deskripsi }}</td>
                            <td>
                                <img src="{{ asset($kanvasing->foto) }}" alt="Foto" style="width: 50px; height: auto; cursor: pointer;"
                                     data-toggle="modal" data-target="#imageModal" onclick="showImageModal('{{ asset($kanvasing->foto) }}')">
                            </td>
                            <td>{{ $kanvasing->lang }}</td>
                            <td>{{ $kanvasing->lat }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('kanvasing.edit', $kanvasing->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('kanvasing.destroy', $kanvasing->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="20" class="text-center">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Preview Foto" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function showImageModal(imageUrl) {
        document.getElementById('modalImage').src = imageUrl;
    }

    $(document).ready(function() {
        var locations = @json($kanvasings->map(function($kanvasing) {
            return [
                'lat' => $kanvasing->lat,
                'lng' => $kanvasing->lang,
                'nama_kk' => $kanvasing->nama_kk
            ];
        }));

        var map = L.map('map').setView([locations[0].lat, locations[0].lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        locations.forEach(function(location) {
            L.marker([location.lat, location.lng]).addTo(map)
                .bindPopup('Nama KK: ' + location.nama_kk + '<br>Lat: ' + location.lat + ', Lng: ' + location.lng)
                .openPopup();
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;

                map.setView([userLat, userLng], 13);
                L.marker([userLat, userLng]).addTo(map)
                    .bindPopup('Your Location')
                    .openPopup();
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    });
</script>

@endsection
