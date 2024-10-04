@extends('mobile.frontend.layout.master')

@section('content')

<style>
    .android-banner,
    .ios-banner {
        display: none;
    }

</style>

<div class="page-content">
    <div class="page-title page-title-large">
        <h2 data-username="{{ auth()->check() ? auth()->user()->name : 'Everyone' }}" class="greeting-text">
        </h2>
        <a href="#" data-menu="menu-main">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                <path d="M7.25687 5.89462C8.06884 5.35208 9.02346 5.0625 10 5.0625C11.3095 5.0625 12.5654 5.5827 13.4913 6.50866C14.4173 7.43462 14.9375 8.6905 14.9375 10C14.9375 10.9765 14.6479 11.9312 14.1054 12.7431C13.5628 13.5551 12.7917 14.188 11.8895 14.5617C10.9873 14.9354 9.99452 15.0331 9.03674 14.8426C8.07896 14.6521 7.19918 14.1819 6.50866 13.4913C5.81814 12.8008 5.34789 11.921 5.15737 10.9633C4.96686 10.0055 5.06464 9.01271 5.43835 8.1105C5.81205 7.20829 6.44491 6.43716 7.25687 5.89462ZM8.29857 12.5464C8.80219 12.8829 9.3943 13.0625 10 13.0625C10.8122 13.0625 11.5912 12.7398 12.1655 12.1655C12.7398 11.5912 13.0625 10.8122 13.0625 10C13.0625 9.3943 12.8829 8.80219 12.5464 8.29857C12.2099 7.79494 11.7316 7.40241 11.172 7.17062C10.6124 6.93883 9.99661 6.87818 9.40254 6.99635C8.80847 7.11451 8.26279 7.40619 7.83449 7.83449C7.40619 8.26279 7.11451 8.80847 6.99635 9.40254C6.87818 9.99661 6.93883 10.6124 7.17062 11.172C7.40241 11.7316 7.79494 12.2099 8.29857 12.5464ZM24.7431 14.1054C23.9312 14.6479 22.9765 14.9375 22 14.9375C20.6905 14.9375 19.4346 14.4173 18.5087 13.4913C17.5827 12.5654 17.0625 11.3095 17.0625 10C17.0625 9.02346 17.3521 8.06884 17.8946 7.25687C18.4372 6.44491 19.2083 5.81205 20.1105 5.43835C21.0127 5.06464 22.0055 4.96686 22.9633 5.15737C23.921 5.34789 24.8008 5.81814 25.4913 6.50866C26.1819 7.19918 26.6521 8.07896 26.8426 9.03674C27.0331 9.99452 26.9354 10.9873 26.5617 11.8895C26.1879 12.7917 25.5551 13.5628 24.7431 14.1054ZM23.7014 7.45363C23.1978 7.11712 22.6057 6.9375 22 6.9375C21.1878 6.9375 20.4088 7.26016 19.8345 7.83449C19.2602 8.40882 18.9375 9.18778 18.9375 10C18.9375 10.6057 19.1171 11.1978 19.4536 11.7014C19.7901 12.2051 20.2684 12.5976 20.828 12.8294C21.3876 13.0612 22.0034 13.1218 22.5975 13.0037C23.1915 12.8855 23.7372 12.5938 24.1655 12.1655C24.5938 11.7372 24.8855 11.1915 25.0037 10.5975C25.1218 10.0034 25.0612 9.38763 24.8294 8.82803C24.5976 8.26844 24.2051 7.79014 23.7014 7.45363ZM7.25687 17.8946C8.06884 17.3521 9.02346 17.0625 10 17.0625C11.3095 17.0625 12.5654 17.5827 13.4913 18.5087C14.4173 19.4346 14.9375 20.6905 14.9375 22C14.9375 22.9765 14.6479 23.9312 14.1054 24.7431C13.5628 25.5551 12.7917 26.1879 11.8895 26.5617C10.9873 26.9354 9.99452 27.0331 9.03674 26.8426C8.07896 26.6521 7.19918 26.1819 6.50866 25.4913C5.81814 24.8008 5.34789 23.921 5.15737 22.9633C4.96686 22.0055 5.06464 21.0127 5.43835 20.1105C5.81205 19.2083 6.44491 18.4372 7.25687 17.8946ZM8.29857 24.5464C8.80219 24.8829 9.3943 25.0625 10 25.0625C10.8122 25.0625 11.5912 24.7398 12.1655 24.1655C12.7398 23.5912 13.0625 22.8122 13.0625 22C13.0625 21.3943 12.8829 20.8022 12.5464 20.2986C12.2099 19.7949 11.7316 19.4024 11.172 19.1706C10.6124 18.9388 9.99661 18.8782 9.40254 18.9963C8.80847 19.1145 8.26279 19.4062 7.83449 19.8345C7.40619 20.2628 7.11451 20.8085 6.99635 21.4025C6.87818 21.9966 6.93883 22.6124 7.17062 23.172C7.40241 23.7316 7.79494 24.2099 8.29857 24.5464ZM19.2569 17.8946C20.0688 17.3521 21.0235 17.0625 22 17.0625C23.3095 17.0625 24.5654 17.5827 25.4913 18.5087C26.4173 19.4346 26.9375 20.6905 26.9375 22C26.9375 22.9765 26.6479 23.9312 26.1054 24.7431C25.5628 25.5551 24.7917 26.1879 23.8895 26.5617C22.9873 26.9354 21.9945 27.0331 21.0367 26.8426C20.079 26.6521 19.1992 26.1819 18.5087 25.4913C17.8181 24.8008 17.3479 23.921 17.1574 22.9633C16.9669 22.0055 17.0646 21.0127 17.4383 20.1105C17.8121 19.2083 18.4449 18.4372 19.2569 17.8946ZM20.2986 24.5464C20.8022 24.8829 21.3943 25.0625 22 25.0625C22.8122 25.0625 23.5912 24.7398 24.1655 24.1655C24.7398 23.5912 25.0625 22.8122 25.0625 22C25.0625 21.3943 24.8829 20.8022 24.5464 20.2986C24.2099 19.7949 23.7316 19.4024 23.172 19.1706C22.6124 18.9388 21.9966 18.8782 21.4025 18.9963C20.8085 19.1145 20.2628 19.4062 19.8345 19.8345C19.4062 20.2628 19.1145 20.8085 18.9963 21.4025C18.8782 21.9966 18.9388 22.6124 19.1706 23.172C19.4024 23.7316 19.7949 24.2099 20.2986 24.5464Z" fill="white" stroke="white" stroke-width="0.125" />
            </svg>

        </a>
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
                    <a href="{{ route('kanvasing.create') }}">
                        <i class="ml-3 mr-3" data-feather="user" style="color: #FF5733;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Kunjungan Warga</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{ route('analisis.read') }}">
                        <i class="ml-3 mr-3" data-feather="pie-chart" style="color: #33B5FF;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">
                            Analisis Suara</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{ route('manajement.read') }}">
                        <i class="ml-3 mr-3" data-feather="users" style="color: #FFC733;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">
                            Manajemen Pilkada</h5>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="content mt-0">
        <div class="row">
            <div class="col-6">
                <a href="#" class="simulate-android-banner btn btn-m btn-full rounded-s shadow-xl text-uppercase font-900 bg-highlight android-banner">Download App</a>
                <a href="#" class="simulate-ios-banner btn btn-m btn-full rounded-s shadow-xl text-uppercase font-900 bg-highlight ios-banner">Download App</a>
            </div>
            <div class="col-6">
                @if (auth()->check())
                <a href="#" class="btn btn-full btn-m rounded-s text-uppercase font-900 shadow-xl bg-highlight">
                    Login
                </a>
                @else
                <a href="{{ route('login') }}" class="btn btn-full btn-m rounded-s text-uppercase font-900 shadow-xl bg-highlight">
                    Login
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="card mt-4 preload-img" data-src="admin/mobile/myhr/images/sikad.png">
        <div class="card-body">
            <h5 class="color-white font-16 font-500" style="font-size: 1rem;">Fitur Lainnya</h5>

            <div class="card card-style ml-0 mr-0 bg-white">
                <div class="row mt-3 pt-1 mb-3">
                    <div class="col-4 text-center">
                        <a href="#">
                            <i class="ml-3 mr-3" data-feather="map-pin" style="color: #FF33A8;"></i>
                            <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Peta
                                Wilayah Kampanye</h5>
                        </a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#">
                            <i class="ml-3 mr-3" data-feather="calendar" style="color: #33FF57;"></i>
                            <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Jadwal
                                Kampanye</h5>
                        </a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#">
                            <i class="ml-3 mr-3" data-feather="file-text" style="color: #8E44AD;"></i>
                            <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Laporan
                                Aktivitas Kampanye</h5>
                        </a>
                    </div>
                </div>

                <div class="row mt-3 pt-1 mb-3">

                    <div class="col-4 text-center">
                        <a href="#">
                            <i class="ml-3 mr-3" data-feather="bar-chart-2" style="color: #33B5FF;"></i>
                            <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Rekam Jejak
                                Kandidat</h5>
                        </a>
                    </div>


                    <div class="col-4 text-center">
                        <a href="#">
                            <i class="ml-3 mr-3" data-feather="activity" style="color: #2ECC71;"></i>
                            <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">
                                Sentiment Analysis</h5>
                        </a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#">
                            <i class="ml-3 mr-3" data-feather="dollar-sign" style="color: #3498DB;"></i>
                            <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">
                                Keuangan</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
    </div>

    <div class="content mb-2">
        <h5 class="float-left font-16 font-500">Berita Pilkada</h5>
        <div class="clearfix"></div>
    </div>
    <!-- Homepage Slider -->
    <div class="single-slider-boxed text-center owl-no-dots owl-carousel">
        <div class="card rounded-l shadow-l" data-card-height="320">
            <div class="card-bottom">
                <h1 class="font-24 font-700">Kandidat Unggulan Pilkada 2024</h1>
                <p class="boxed-text-xl">
                    Kenali kandidat-kandidat unggulan dalam Pilkada 2024 dan visi misi yang mereka tawarkan untuk
                    kemajuan daerah.
                </p>
            </div>
            <div class="card-overlay bg-gradient-fade"></div>
            <div class="card-bg owl-lazy" data-src="https://example.com/kandidat.jpg"></div>
        </div>
        <div class="card rounded-l shadow-l" data-card-height="320">
            <div class="card-bottom">
                <h1 class="font-24 font-700">Persiapan Tahapan Pemilihan</h1>
                <p class="boxed-text-xl">
                    Pelajari lebih lanjut tentang tahapan Pilkada yang sedang berlangsung dan apa yang perlu
                    diperhatikan sebagai pemilih.
                </p>
            </div>
            <div class="card-overlay bg-gradient-fade"></div>
            <div class="card-bg owl-lazy" data-src="https://example.com/tahapan.jpg"></div>
        </div>
        <div class="card rounded-l shadow-l" data-card-height="320">
            <div class="card-bottom">
                <h1 class="font-24 font-700">Pantauan dan Hasil Sementara</h1>
                <p class="boxed-text-xl">
                    Ikuti perkembangan terbaru mengenai hasil sementara Pilkada dari berbagai daerah di Indonesia.
                </p>
            </div>
            <div class="card-overlay bg-gradient-fade"></div>
            <div class="card-bg owl-lazy" data-src="https://example.com/hasil-sementara.jpg"></div>
        </div>
    </div>



    <div id="menu-install-pwa-android" class="menu menu-box-bottom menu-box-detached rounded-l android-banner" data-menu-height="350" data-menu-effect="menu-parallax">
        <div class="boxed-text-l mt-4">
            <img class="rounded-l mb-3" src="{{ asset('mobile/images/logo.png') }}" alt="img" width="90">
            <h4 class="text-center mt-4 mb-2">Install Sikadsis</h4>
            <p>Sistem Informasi Kampanye dan Analisis Pilkada Sistematis </p>
            <a href="#" class="pwa-install mx-auto btn btn-m rounded-s text-uppercase font-900 bg-highlight">Install</a>
            <div class="clear"></div>
        </div>
    </div>

    <!-- Install instructions for iOS -->
    <div id="menu-install-pwa-ios" class="menu menu-box-bottom menu-box-detached rounded-l ios-banner" data-menu-height="320" data-menu-effect="menu-parallax">
        <div class="boxed-text-l mt-4">
            <img class="rounded-l mb-3" src="{{ asset('mobile/images/logo.png') }}" alt="img" width="90">
            <h4 class="text-center mt-4 mb-2">Install Sikadsis</h4>
            <p>Sistem Informasi Kampanye dan Analisis Pilkada Sistematis </p>
            <a href="#" class="pwa-install mx-auto btn btn-m rounded-s text-uppercase font-900 bg-highlight">Install</a>
            <div class="clear"></div>
        </div>
    </div>


</div>

<script>
    let deferredPrompt;
    const installBtn = document.querySelectorAll('.pwa-install');
    const dismissBtn = document.querySelectorAll('.pwa-dismiss');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent the mini-infobar from appearing on mobile
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Show the install button
        document.getElementById('menu-install-pwa-android').style.display = 'block';
    });

    installBtn.forEach(button => {
        button.addEventListener('click', () => {
            if (deferredPrompt) {
                // Hide the install button
                document.getElementById('menu-install-pwa-android').style.display = 'none';
                // Show the install prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then((result) => {
                    if (result.outcome === 'accepted') {
                        console.log('User accepted the A2HS prompt');
                    } else {
                        console.log('User dismissed the A2HS prompt');
                    }
                    deferredPrompt = null;
                });
            }
        });
    });

    dismissBtn.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('menu-install-pwa-android').style.display = 'none';
        });
    });

    function detectDevice() {
        const userAgent = navigator.userAgent || navigator.vendor || window.opera;

        if (/android/i.test(userAgent)) {
            document.querySelector('.android-banner').style.display = 'block';
            document.querySelector('.ios-banner').style.display = 'none';
        } else if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            document.querySelector('.ios-banner').style.display = 'block';
            document.querySelector('.android-banner').style.display = 'none';
        } else {
            // Default to Android banner if no device detected
            document.querySelector('.android-banner').style.display = 'block';
            document.querySelector('.ios-banner').style.display = 'none';
        }
    }

    detectDevice();
</script>
@endsection
