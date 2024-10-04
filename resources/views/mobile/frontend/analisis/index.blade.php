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

    <!-- Homepage Slider -->
    <div class="content text-center">
        <div class="card card-style ml-0 mr-0 bg-white">
            <div class="row mt-3 pt-1 mb-3">
                <div class="col-4 text-center">
                    <a href="{{ route('analisis.grafik-suara') }}">
                        <i class="ml-3 mr-3" data-feather="map-pin" style="color: #FF5733;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Suara per Wilayah</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{ route('analisis.strength') }}">
                        <i class="ml-3 mr-3" data-feather="shield" style="color: #28a745;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Wilayah Tertinggi</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{ route('analisis.weakness') }}">
                        <i class="ml-3 mr-3" data-feather="alert-triangle" style="color: #dc3545;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Wilayah Terendah</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
