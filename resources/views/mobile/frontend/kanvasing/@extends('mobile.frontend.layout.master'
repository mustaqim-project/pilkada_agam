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
    <form method="POST" action="{{ route('kanvasing.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card card-style">
            <div class="content mb-0 mt-1">
                <!-- user id -->
                <Label>Tim Lapangan</Label>
                @if (Route::has('login'))
                <div class="input-style has-icon input-style-1 input-required">
                    <select name="user_id" id="user_id" class="input" required>
                        <option id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                            {{ Auth::user()->name }}
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>
                @endif

                <!-- Provinsi -->
                <div class="input-style has-icon input-style-1 input-required">
                    <span>Provinsi</span>
                    <em>(*Wajib Diisi)</em>
                    <select name="provinsi" id="provinsi" class="input" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                </div>

                <!-- Kabupaten/Kota -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Kabupaten/Kota</span>
                    <em>(*Wajib Diisi)</em>
                    <select name="kabupaten_kota" id="kabupaten_kota" class="input" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                    <x-input-error :messages="$errors->get('kabupaten_kota')" class="mt-2" />
                </div>


                <!-- Kecamatan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Kecamatan</span>
                    <em>(*Wajib Diisi)</em>
                    <select name="kecamatan" id="kecamatan" class="input" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                </div>

                <!-- Kelurahan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Kelurahan</span>
                    <em>(*Wajib Diisi)</em>
                    <select name="kelurahan" id="kelurahan" class="input" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    <x-input-error :messages="$errors->get('kelurahan')" class="mt-2" />
                </div>

                <!-- RW -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-ruler color-theme"></i>
                    <span>RW</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="rw" class="input" type="text" name="rw" :value="old('rw')" required placeholder="RW" />
                    <x-input-error :messages="$errors->get('rw')" class="mt-2" />
                </div>

                <!-- RT -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-ruler color-theme"></i>
                    <span>RT</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="rt" class="input" type="text" name="rt" :value="old('rt')" required placeholder="RT" />
                    <x-input-error :messages="$errors->get('rt')" class="mt-2" />
                </div>

                <!-- Tipe Cakada ID -->
                <label class="mt-4">Pilkada</label>
                <em>(*Wajib Diisi)</em>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="tipe_cakada_id" name="tipe_cakada_id" class="input" required>
                        <option value="" disabled selected>Pilih Tipe Pilkada</option>
                        @foreach ($tipe_cakada as $item)
                        <option value="{{ $item->id }}" {{ old('tipe_cakada_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipe_cakada_id')" class="mt-2" />
                </div>

                <!-- Cakada ID -->
                <label class="mt-4">Nama Kandidat</label>
                <em>(*Wajib Diisi)</em>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="cakada_id" name="cakada_id" class="input" required>
                        <option value="">Pilih Nama Kandidat</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <x-input-error :messages="$errors->get('cakada_id')" class="mt-2" />
                </div>
                <!-- Nama KK -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-user color-theme"></i>
                    <span>Nama KK</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="nama_kk" class="input" type="text" name="nama_kk" :value="old('nama_kk')" required placeholder="Nama KK" />
                    <x-input-error :messages="$errors->get('nama_kk')" class="mt-2" />
                </div>

                <label class="mt-4">Pekerjaan</label>
                <em>(*Wajib Diisi)</em>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="pekerjaan_id" name="pekerjaan_id" class="input" required>
                        <option value="" disabled selected>Pilih Pekerjaan</option>
                        @foreach ($pekerjaan as $item)
                        <option value="{{ $item->id }}" {{ old('pekerjaan_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_pekerjaan }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pekerjaan_id')" class="mt-2" />
                </div>

                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-calendar color-theme"></i>
                    <span>Usia</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="usia" class="input" type="number" name="usia" :value="old('usia')" required placeholder="Masukkan Usia" min="17" />
                    <x-input-error :messages="$errors->get('usia')" class="mt-2" />
                </div>

                <label class="mt-4">Jenis Kelamin</label>
                <em>(*Wajib Diisi)</em>
                <div class="input-style has-icon input-style-1 input-required mt-2">
                    <select id="jenis_kelamin" name="jenis_kelamin" class="input" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('jenis_kelamin') == '1' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="2" {{ old('jenis_kelamin') == '2' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>

                <!-- Nomor HP -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-phone color-theme"></i>
                    <span>Nomor HP</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="nomor_hp" class="input" type="text" name="nomor_hp" :value="old('nomor_hp')" required placeholder="Nomor HP" />
                    <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
                </div>

                <!-- Jumlah Pemilih -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-users color-theme"></i>
                    <span>Jumlah Pemilih</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="jum_pemilih" class="input" type="number" name="jum_pemilih" :value="old('jum_pemilih')" required placeholder="Jumlah Pemilih" />
                    <x-input-error :messages="$errors->get('jum_pemilih')" class="mt-2" />
                </div>

                <!-- Alamat -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <span>Alamat</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="alamat" class="input" type="text" name="alamat" :value="old('alamat')" required placeholder="Alamat" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>



                <!-- Popularitas -->
                <label class="mt-4">Apakah kenal dengan calon ?</label>
                <em>(*Wajib Diisi)</em>
                <div class="input-style has-icon input-style-1 input-required mt-2">
                    <select id="popularitas" name="popularitas" class="input" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('popularitas') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="2" {{ old('popularitas') == '2' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <x-input-error :messages="$errors->get('popularitas')" class="mt-2" />
                </div>

                <!-- Elektabilitas -->
                <label class="mt-4">Apakah anda akan memilih calon tersebut?</label>
                <em>(*Wajib Diisi)</em>
                <div class="input-style has-icon input-style-1 input-required mt-2">
                    <select id="elektabilitas" name="elektabilitas" class="input" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('elektabilitas') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="2" {{ old('elektabilitas') == '2' ? 'selected' : '' }}>Tidak</option>
                        <option value="3" {{ old('elektabilitas') == '3' ? 'selected' : '' }}>Ragu-ragu</option>
                    </select>
                    <x-input-error :messages="$errors->get('elektabilitas')" class="mt-2" />
                </div>
                <!-- Alasan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <span>Alasan memilih calon tersebut ?</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="alasan" class="input" type="text" name="alasan" :value="old('alasan')" required placeholder="alasan memilih kandidat" />
                    <x-input-error :messages="$errors->get('alasan')" class="mt-2" />
                </div>
                <!-- pesan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <span>Pesan untuk calon kepala daerah jika terpilih?</span>
                    <em>(*Wajib Diisi)</em>
                    <x-text-input id="pesan" class="input" type="text" name="pesan" :value="old('pesan')" required placeholder="pesan untuk kandidat" />
                    <x-input-error :messages="$errors->get('pesan')" class="mt-2" />
                </div>

                <!-- Stiker -->
                <label class="mt-4">Apakah boleh memasang atribut kampanye berupa stiker/pamflet/brosur dll?</label>
                <em>(*Wajib Diisi)</em>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="stiker" name="stiker" class="input" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('stiker') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="2" {{ old('stiker') == '2' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <x-input-error :messages="$errors->get('stiker')" class="mt-2" />
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
                <input type="file" id="foto" name="foto" accept="image/*" style="display:none;">



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
            $('#lat').val(lat);
            $('#lang').val(lng);

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
        const profilePictureInput = $('#foto');
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

        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json'
            , method: 'GET'
            , success: function(data) {
                let provinsiDropdown = $('#provinsi');
                data.forEach(function(provinsi) {
                    provinsiDropdown.append('<option value="' + provinsi.id + '">' + provinsi.name + '</option>');
                });
            }
        });

        // Load kabupaten/kota when a provinsi is selected
        $('#provinsi').change(function() {
            let provinsiId = $(this).val();
            $('#kabupaten_kota').html('<option value="">Pilih Kabupaten/Kota</option>');
            if (provinsiId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`
                    , method: 'GET'
                    , success: function(data) {
                        data.forEach(function(kabupaten) {
                            $('#kabupaten_kota').append('<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>');
                        });
                    }
                });
            }
        });

        // Load kecamatan when a kabupaten/kota is selected
        $('#kabupaten_kota').change(function() {
            let kabupatenId = $(this).val();
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            if (kabupatenId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`
                    , method: 'GET'
                    , success: function(data) {
                        data.forEach(function(kecamatan) {
                            $('#kecamatan').append('<option value="' + kecamatan.id + '">' + kecamatan.name + '</option>');
                        });
                    }
                });
            }
        });

        // Load kelurahan when a kecamatan is selected
        $('#kecamatan').change(function() {
            let kecamatanId = $(this).val();
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');
            if (kecamatanId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`
                    , method: 'GET'
                    , success: function(data) {
                        data.forEach(function(kelurahan) {
                            $('#kelurahan').append('<option value="' + kelurahan.id + '">' + kelurahan.name + '</option>');
                        });
                    }
                });
            }
        });

        $('#provinsi, #kabupaten_kota, #tipe_cakada_id').change(function() {
            let provinsi = $('#provinsi').val();
            let kabupatenKota = $('#kabupaten_kota').val();
            let tipeCakada = $('#tipe_cakada_id').val();

            $.ajax({
                url: "{{ route('getCakadaByFilters') }}"
                , method: 'GET'
                , data: {
                    provinsi: provinsi
                    , kabupaten_kota: kabupatenKota
                    , tipe_cakada_id: tipeCakada
                }
                , success: function(response) {
                    let options = '<option value="">Pilih Nama Kandidat</option>';
                    $.each(response, function(index, cakada) {
                        options += `<option value="${cakada.id}">${cakada.nama_calon_kepala}-${cakada.nama_calon_wakil}</option>`;
                    });
                    $('#cakada_id').html(options);
                }
            });
        });

    });

    function handleAccessChoice() {
        const accessChoice = document.getElementById('accessChoice').value;
        const fotoInput = document.getElementById('foto');

        // Set the input to accept images and open the file input dialog
        fotoInput.setAttribute('accept', 'image/*');

        // If 'camera' is selected, set capture to 'camera' to open the camera
        if (accessChoice === 'camera') {
            fotoInput.setAttribute('capture', 'camera');
        } else {
            fotoInput.removeAttribute('capture');
        }

        // Trigger the file input dialog
        fotoInput.click();
    }

    // Preview selected image
    document.getElementById('foto').addEventListener('change', function(event) {
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
    });

    // Cookie Permission for Camera Access (Optional)
    function checkCameraPermission() {
        const permission = getCookie('camera_permission');

        if (permission !== 'granted') {
            alert('Silakan izinkan akses kamera untuk menggunakan fitur ini.');
            setCookie('camera_permission', 'granted', 30);
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

    // Check camera permission on page load
    window.onload = checkCameraPermission;

</script>
@endsection
