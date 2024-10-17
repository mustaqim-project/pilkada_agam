@extends('mobile.frontend.layout.master')

@section('content')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .table th {
            background-color: #03836d;
            /* Bootstrap primary color */
            color: white;
            /* White text for table header */
            text-align: center;
            /* Center align header text */
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

        <!-- Tabel Daftar Kanvasing Wisata -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>No KTP</th>
                                <th>Nama Responden</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Nomor HP</th>
                                <th>Pekerjaan</th> <!-- Changed header to reflect job title -->
                                <th>Alamat</th>
                                <th>Foto Kegiatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kanvasingWisata as $kanvasing)
                                <tr>
                                    <td>{{ $kanvasing->id }}</td>
                                    <td>{{ $kanvasing->kecematan->nama_kecamatan ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $kanvasing->kelurahan->nama_kelurahan ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $kanvasing->no_ktp }}</td>
                                    <td>{{ $kanvasing->nama_responden }}</td>
                                    <td>{{ optional($kanvasing->tgl_lahir)->format('d-m-Y') ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $kanvasing->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $kanvasing->no_hp }}</td>
                                    <td>{{ $kanvasing->pekerjaan->name ?? 'Tidak Diketahui' }}</td>
                                    <!-- Map pekerjaan_id to job name -->
                                    <td>{{ $kanvasing->alamat }}</td>
                                    <td>
                                        <img src="{{ asset($kanvasing->foto_kegiatan) }}" alt="Foto Kegiatan"
                                            style="width: 50px; height: auto; cursor: pointer;" data-toggle="modal"
                                            data-target="#imageModal"
                                            onclick="showImageModal('{{ asset($kanvasing->foto_kegiatan) }}')">
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            {{-- <a href="{{ route('kanvasing.edit', $kanvasing->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a> --}}
                                            <form action="{{ route('kanvasing.destroy', $kanvasing->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete-item">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Image Preview -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
            aria-hidden="true">
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

        // $(document).ready(function() {
        //     var locations = @json(
        //         $kanvasingWisata->map(function ($kanvasing) {
        //             return [
        //                 'lat' => $kanvasing->latitude,
        //                 'lng' => $kanvasing->longitude,
        //                 'nama_kk' => $kanvasing->nama_responden, // Assuming nama_kk refers to the respondent's name
        //             ];
        //         }));

        //     // Check if locations are available before accessing them
        //     var initialLat = locations.length > 0 ? locations[0].lat : 0;
        //     var initialLng = locations.length > 0 ? locations[0].lng : 0;

        //     var map = L.map('map').setView([initialLat, initialLng], 13); // Default to (0,0) if no location

        //     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //         maxZoom: 19
        //     }).addTo(map);

        //     locations.forEach(function(location) {
        //         L.marker([location.lat, location.lng]).addTo(map)
        //             .bindPopup('Nama KK: ' + location.nama_kk + '<br>Lat: ' + location.lat + ', Lng: ' +
        //                 location.lng)
        //             .openPopup();
        //     });

        //     if (navigator.geolocation) {
        //         navigator.geolocation.getCurrentPosition(function(position) {
        //             var userLat = position.coords.latitude;
        //             var userLng = position.coords.longitude;

        //             map.setView([userLat, userLng], 13);
        //             L.marker([userLat, userLng]).addTo(map)
        //                 .bindPopup('Your Location')
        //                 .openPopup();
        //         });
        //     } else {
        //         console.log("Geolocation is not supported by this browser.");
        //     }
        // });
    </script>
@endsection
