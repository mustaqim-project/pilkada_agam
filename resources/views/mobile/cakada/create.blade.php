@extends('mobile.frontend.layout.master')

@section('content')
<div class="page-content" style="min-height:60vh!important">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}" data-back-button><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>


    <div class="card card-style">
        <div class="content mb-2">
            <form action="{{ route('cakada.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="form-control">
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="kabupaten_kota">Kabupaten/Kota</label>
                    <select name="kabupaten_kota" id="kabupaten_kota" class="form-control" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tipe_cakada_id">Tipe Pilkada</label>
                    <select id="tipe_cakada_id" name="tipe_cakada_id" class="form-control" required>
                        @foreach ($tipe_cakada as $item)
                            <option value="{{ $item->id }}" {{ old('tipe_cakada_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="form-group">
                    <label for="nama_calon_kepala">Nama Calon Kepala</label>
                    <input type="text" name="nama_calon_kepala" id="nama_calon_kepala" class="form-control">
                </div>

                <div class="form-group">
                    <label for="nama_calon_wakil">Nama Calon Wakil</label>
                    <input type="text" name="nama_calon_wakil" id="nama_calon_wakil" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fetch Provinces and populate the dropdown
        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
            method: 'GET',
            success: function(data) {
                let provinsiDropdown = $('#provinsi');
                data.forEach(function(provinsi) {
                    provinsiDropdown.append('<option value="' + provinsi.id + '">' + provinsi.name + '</option>');
                });
            },
            error: function() {
                alert('Error fetching provinces. Please try again.');
            }
        });

        $('#provinsi').change(function() {
            let provinsiId = $(this).val();
            $('#kabupaten_kota').html('<option value="">Pilih Kabupaten/Kota</option>');
            if (provinsiId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(kabupaten) {
                            $('#kabupaten_kota').append('<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Error fetching regencies. Please try again.');
                    }
                });
            }
        });
    });
</script>

@endsection
