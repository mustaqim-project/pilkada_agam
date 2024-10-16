@extends('mobile.frontend.layout.master')

@section('content')
    <style>
        /* Styling untuk gambar pratinjau */
        #image_preview {
            max-width: 100%;
            height: auto;
            display: block;
            margin-top: 10px;
            border-radius: 0.375rem;
            /* Menambahkan radius sudut untuk pratinjau gambar */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Menambahkan bayangan pada gambar */
        }

        /* Styling umum untuk kontainer */
        .container {
            margin-top: 20px;
        }

        /* Styling tombol umum */
        .btn-full {
            display: inline-block;
            width: 100%;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Gaya khusus untuk tombol sorot (highlight) */
        .btn-highlight {
            background-color: #28a745;
        }

        /* Gaya hover untuk tombol */
        .btn-full:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Gaya fokus untuk tombol */
        .btn-full:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
        }

        /* Styling untuk input file */
        .upload-file {
            display: block;
            width: 100%;
            padding: 0.75rem;
            border: 2px dashed #007bff;
            border-radius: 0.375rem;
            background-color: #f8f9fa;
            cursor: pointer;
            text-align: center;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        /* Gaya saat file input di-hover */
        .upload-file:hover {
            border-color: #0056b3;
            background-color: #e2e6ea;
        }

        /* Styling teks pada file input */
        .upload-file-text {
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }

        /* Styling untuk dropdown pilihan akses */
        select#accessChoice {
            width: 100%;
            padding: 0.75rem 1.25rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            background-color: #f8f9fa;
            color: #ffff;
            font-size: 1rem;
            font-weight: 400;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Gaya dropdown saat difokuskan */
        select#accessChoice:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
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
        <form method="POST" action="{{ route('kanvasing_wisata.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card card-style">
                <div class="content mb-0 mt-1">
                    <!-- user id -->
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


                    <!-- Input Kecamatan -->
                    <div class="input-style has-icon input-style-1 input-required">
                        <span>Kecamatan</span>
                        <em>(*Wajib Diisi)</em>
                        <select name="kecematan_id" id="kecematan_id" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                        @error('kecematan_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Kelurahan -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <span>Kelurahan</span>
                        <em>(*Wajib Diisi)</em>
                        <select name="kelurahan_id" id="kelurahan_id" required>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                        @error('kelurahan_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Input Nomor KTP -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-id-card color-theme"></i>
                        <span>Nomor KTP</span>
                        <em>(*Wajib Diisi)</em>
                        <input type="text" name="no_ktp" required maxlength="16" placeholder="Nomor KTP" />
                        @error('no_ktp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Nama Responden -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-user color-theme"></i>
                        <span>Nama Responden</span>
                        <em>(*Wajib Diisi)</em>
                        <input type="text" name="nama_responden" required maxlength="255" placeholder="Nama Responden" />
                        @error('nama_responden')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Tanggal Lahir -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-calendar color-theme"></i>
                        <span>Tanggal Lahir</span>
                        <em>(*Wajib Diisi)</em>
                        <input type="date" name="tgl_lahir" required />
                        @error('tgl_lahir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Jenis Kelamin -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <span>Jenis Kelamin</span>
                        <em>(*Wajib Diisi)</em>
                        <select name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Pekerjaan -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <span>Pekerjaan</span>
                        <em>(*Wajib Diisi)</em>
                        <select name="pekerjaan_id" required>
                            <option value="">Pilih Pekerjaan</option>
                            @foreach ($pekerjaans as $pekerjaan)
                                <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->name }}</option>
                            @endforeach
                        </select>
                        @error('pekerjaan_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Alamat -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-home color-theme"></i>
                        <span>Alamat</span>
                        <em>(*Wajib Diisi)</em>
                        <input type="text" name="alamat" required maxlength="255" placeholder="Alamat" />
                        @error('alamat')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <label class="mt-5">Upload Foto Kegiatan</label>
                    <em>(*Wajib Diisi)</em>

                    <!-- Image Preview -->
                    <div class="mt-4">
                        <img id="image_preview" src="" alt="Image Preview" style="display:none;" />
                    </div>

                    <!-- Pilihan Akses -->
                    <div class="mt-4">
                        <select id="accessChoice" class="bg-highlight shadow-s rounded-s" onchange="handleAccessChoice()">
                            <option value="">Pilih Upload Dari Kamera / Galeri</option>
                            <option value="camera">Dari Kamera</option>
                            <option value="gallery">Dari Galeri</option>
                        </select>
                    </div>

                    <!-- Hidden Input for File Upload -->
                    <input type="file" id="foto_kegiatan" name="foto_kegiatan" accept="image/*" style="display:none;">



                    <!-- deskripsi -->
                    <label class="mt-5">Kendala dilapangan jika ada!</label>
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-address-card color-theme"></i>
                        <x-text-input id="deskripsi" class="input" type="text" name="deskripsi" :value="old('deskripsi')" placeholder="Kendala dilapangan jika ada!" />
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>
                    <!-- Lokasi Saya -->
                    <div class="input-style has-icon input-style-1 mt-4">
                        <i class="input-icon fa fa-map-pin color-theme"></i>
                        <span>Lokasi Saya</span>
                        <x-text-input id="location_name" class="input" type="text" name="location_name" readonly :value="old('location_name')" placeholder="Lokasi Saya" />
                        <x-input-error :messages="$errors->get('location_name')" class="mt-2" />
                    </div>
                    <!-- Lokasi Saya -->
                    <div class="input-style has-icon input-style-1 mt-4">
                        <span>Longitude</span>
                        <em>(*Wajib Diisi)</em>
                        <x-text-input id="lang" class="input" type="text" name="lang" readonly :value="old('lang')" />
                        <x-input-error :messages="$errors->get('lang')" class="mt-2" />
                    </div>
                    <div class="input-style has-icon input-style-1 mt-4">
                        <span>Latitude</span>
                        <em>(*Wajib Diisi)</em>
                        <x-text-input id="lat" class="input" type="text" name="lat" readonly :value="old('lat')" />
                        <x-input-error :messages="$errors->get('lat')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <h3 class="font-700">Get Coordinates</h3>
                    <a href="#" class="get-location btn btn-full btn-m bg-red2-dark rounded-sm text-uppercase shadow-l font-900">Get
                        my Location</a>
                    <p class="location-coordinates"></p>

                </div>
                <div class="responsive-iframe add-iframe">
                    <iframe class="location-map" src='https://maps.google.com/?ie=UTF8&amp;ll=47.595131,-122.330414&amp;spn=0.006186,0.016512&amp;t=h&amp;z=17&amp;output=embed'></iframe>
                </div>
            </div>




            <button type="submit" class="btn btn-full btn-highlight">Simpan</button>
        </form>

        <div id="map" style="display: none;"></div>

    </div>

    <script>
        $(document).ready(function() {
            checkLocationPermission();

            $('.get-location').on('click', function(e) {
                e.preventDefault(); // Prevent the default anchor click behavior
                getLocation();
            });

            // Initialize the map
            var map = L.map('map').setView([51.505, -0.09], 13);

            // Add a tile layer (OpenStreetMap in this case)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            // Function to get the user's location and update the map
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else {
                    console.log("Geolocation is not supported by this browser.");
                }
            }

            function showPosition(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                // Update hidden fields with user's location
                $('#latitude').val(lat);
                $('#longitude').val(lng);

                // Center the map and add a marker for the user's location
                map.setView([lat, lng], 13);
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('Lokasi Saya')
                    .openPopup();

                // Get the location name using reverse geocoding
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        var locationName = data.display_name;
                        $('#location_name').val(locationName);
                    })
                    .catch(error => console.error('Error fetching location name:', error));
            }

            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        console.log("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        console.log("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        console.log("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        console.log("An unknown error occurred.");
                        break;
                }
            }

            // Check location permission and set cookie
            function checkLocationPermission() {
                const permission = getCookie('location_permission');

                if (permission !== 'granted') {
                    alert('Silakan izinkan akses lokasi untuk menggunakan fitur ini.');
                    setCookie('location_permission', 'granted', 30); // Save permission in cookie for 30 days
                }
            }

            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }

            function setCookie(name, value, days) {
                const expires = new Date(Date.now() + days * 864e5).toUTCString();
                document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
            }

            // Profile picture preview
            const profilePictureInput = $('#foto_kegiatan');
            const imagePreview = $('#image_preview');

            profilePictureInput.on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.attr('src', '#').hide();
                }
            });




            $('#kecematan_id').change(function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().append(
                    '<option value="">Pilih Kelurahan</option>'); // Kosongkan dropdown kelurahan

                if (kecamatanId) {
                    $.ajax({
                        url: '/kelurahans/' + kecamatanId,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan
                                    .id + '">' + kelurahan.nama_kelurahan +
                                    '</option>');
                            });
                        }
                    });
                }
            });

        });

        // Fungsi untuk menangani pemilihan akses (kamera atau galeri)
        function handleAccessChoice() {
            const accessChoice = document.getElementById('accessChoice').value;
            const cameraInput = document.getElementById('cameraInput');
            const galleryInput = document.getElementById('galleryInput');

            // Mengecek izin cookie untuk kamera
            if (accessChoice === 'camera' && !checkPermissionCookie('camera_permission')) {
                alert('Silakan izinkan akses kamera.');
                setPermissionCookie('camera_permission', 'granted', 30);
            }

            // Mengecek izin cookie untuk galeri
            if (accessChoice === 'gallery' && !checkPermissionCookie('gallery_permission')) {
                alert('Silakan izinkan akses galeri.');
                setPermissionCookie('gallery_permission', 'granted', 30);
            }

            // Reset semua input
            cameraInput.style.display = 'none';
            galleryInput.style.display = 'none';

            // Jika 'camera' dipilih, tampilkan input kamera
            if (accessChoice === 'camera') {
                cameraInput.style.display = 'none';
                cameraInput.click();
            }
            // Jika 'gallery' dipilih, tampilkan input galeri
            else if (accessChoice === 'gallery') {
                galleryInput.style.display = 'none';
                galleryInput.click();
            }
        }

        // Preview gambar yang dipilih
        document.getElementById('cameraInput').addEventListener('change', function(event) {
            previewImage(event);
        });

        document.getElementById('galleryInput').addEventListener('change', function(event) {
            previewImage(event);
        });

        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imagePreview = document.getElementById('image_preview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // Fungsi untuk mengecek cookie izin
        function checkPermissionCookie(permissionName) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${permissionName}=`);
            if (parts.length === 2) return parts.pop().split(';').shift() === 'granted';
            return false;
        }

        // Fungsi untuk menyimpan cookie izin
        function setPermissionCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
        }

        // Mengecek dan meminta izin kamera pada saat halaman di-load (optional)
        window.onload = function() {
            if (!checkPermissionCookie('camera_permission')) {
                alert('Silakan izinkan akses kamera untuk menggunakan fitur ini.');
            }
        };
    </script>
@endsection
