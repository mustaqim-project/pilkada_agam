@extends('mobile.frontend.layout.master')

@section('content')
<style>
    /* Menyesuaikan font-size dan padding untuk layar kecil */
    @media (max-width: 768px) {
        table {
            font-size: 0.75em; /* Set font-size relatif terhadap ukuran font default */
        }
        table th, table td {
            padding: 0.5em; /* Padding diatur menggunakan em */
        }
        .btn {
            font-size: 0.75em;
            padding: 0.5em 1em;
        }
    }

    /* Untuk layar sangat kecil, kita bisa mengurangi lagi ukuran teks */
    @media (max-width: 480px) {
        table {
            font-size: 0.75em; /* Set font-size relatif terhadap ukuran font default */
        }
        table th, table td {
            padding: 0.5em; /* Padding diatur menggunakan em */
        }
        .btn {
            font-size: 0.75em;
            padding: 0.5em 1em;
        }
    }
</style>

<div class="page-content" style="min-height:60vh!important">
    <div class="page-title page-title-small">
        <h2>
            <a href="{{ route('dashboard') }}" data-back-button><i class="fa fa-arrow-left"></i></a>
            Beranda
        </h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>

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

    <div class="card card-style">
        <div class="content mb-2">
            <h3>Calon Kepala Daerah</h3>
            <a href="{{ route('cakada.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Tambah Data') }}
            </a>
            <!-- Add table-responsive to make table scrollable on small screens -->
            <div class="table-responsive">
                <table class="table text-center rounded-sm shadow-l">
                    <thead>
                        <tr class="bg-gray1-dark">
                            <th scope="col" class="color-theme">#</th>
                            <th scope="col" class="color-theme">Provinsi</th>
                            <th scope="col" class="color-theme">Kabupaten/Kota</th>
                            <th scope="col" class="color-theme">Nama Calon Kepala</th>
                            <th scope="col" class="color-theme">Nama Calon Wakil</th>
                            <th scope="col" class="color-theme">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $provinsiMap = collect($provinsi)->pluck('name', 'id')->toArray();
                        @endphp

                        @forelse ($cakadas as $cakada)
                            @php
                                $provinsiName = $provinsiMap[$cakada->provinsi] ?? 'Unknown';
                                $regencies = app('App\Http\Controllers\CakadaController')->getRegencies($cakada->provinsi);
                                $regenciesMap = collect($regencies)->pluck('name', 'id')->toArray();
                                $kabupatenKotaName = $regenciesMap[$cakada->kabupaten_kota] ?? 'Unknown';
                            @endphp
                            <tr>
                                <td scope="row">{{ $cakada->id }}</td>
                                <td class="color-dark">{{ $provinsiName }}</td>
                                <td class="color-dark">{{ $kabupatenKotaName }}</td>
                                <td class="color-dark">{{ $cakada->nama_calon_kepala }}</td>
                                <td class="color-dark">{{ $cakada->nama_calon_wakil }}</td>
                                <td class="color-dark">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a class="btn btn-warning btn-sm" href="{{ route('cakada.edit', $cakada->id) }}">Edit</a>
                                        <form action="{{ route('cakada.destroy', $cakada->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
            method: 'GET',
            success: function(data) {
                let provinsiDropdown = $('#provinsi');
                data.forEach(function(provinsi) {
                    provinsiDropdown.append('<option value="' + provinsi.id + '">' + provinsi.name + '</option>');
                });
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
                    }
                });
            }
        });

    });
</script>

@endsection
