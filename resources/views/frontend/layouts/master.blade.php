<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>@hasSection('title') @yield('title') @else {{ $settings['site_seo_title'] }} @endif </title>
    <meta name="description" content="@hasSection('meta_description') @yield('meta_description') @else {{ $settings['site_seo_description'] }} @endif " />
    <meta name="keywords" content="@hasSection('meta_keyword') @yield('meta_keyword') @else {{ $settings['site_seo_keywords'] }} @endif " />

    <meta name="og:title" content="@yield('meta_og_title')" />
    <meta name="og:description" content="@yield('meta_og_description')" />
    <meta name="og:image" content="@hasSection('meta_og_image') @yield('meta_og_image') @else {{ asset($settings['site_logo']) }} @endif" />
    <link rel="manifest" href="{{ asset('mobile/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mobile/images/logo.png') }}">
    <link rel="icon" href="{{ asset('mobile/images/logo.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset($settings['site_favicon']) }}" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('mobile/scripts/jquery.js') }}"></script>

    <style>
        :root {
            --colorPrimary: {{ $settings['site_color'] }};
        }
           .lazy {
            opacity: 0;
            transition: opacity 0.3s;
        }
        .lazy.loaded {
            opacity: 1;
        }
    </style>


<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5016031411419450"
     crossorigin="anonymous"></script>
     <meta name="google-adsense-account" content="ca-pub-5016031411419450">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FZQWWJHNHP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FZQWWJHNHP');

    </script>

</head>

<body>


    <!-- Global Variables -->
    @php
        $socialLinks = \App\Models\SocialLink::where('status', 1)->get();
        $footerInfo = \App\Models\FooterInfo::where('language', getLangauge())->first();
        $footerGridOne = \App\Models\FooterGridOne::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridTwo = \App\Models\FooterGridTwo::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridThree = \App\Models\FooterGridThree::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridOneTitle = \App\Models\FooterTitle::where(['key' => 'grid_one_title', 'language' => getLangauge()])->first();
        $footerGridTwoTitle = \App\Models\FooterTitle::where(['key' => 'grid_two_title', 'language' => getLangauge()])->first();
        $footerGridThreeTitle = \App\Models\FooterTitle::where(['key' => 'grid_three_title', 'language' => getLangauge()])->first();
    @endphp

    <!-- Header news -->
    @include('frontend.layouts.header')
    <!-- End Header news -->

    @yield('content')

    <!-- Footer Section -->
    @include('frontend.layouts.footer')
    <!-- End Footer Section -->


    <a href="javascript:" id="return-to-top"  aria-label="Return to top of the page"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>



        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        // Add csrf token in ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

    $('#site-language').on('change', function() {
        let languageCode = $(this).val();
        $('html').attr('lang', languageCode);
        $.ajax({
            method: 'GET',
            url: "{{ route('language') }}",
            data: {
                language_code: languageCode
            },
            success: function(data) {
                if (data.status === 'success') {
                    window.location.href = "{{ url('/') }}";
                }
            },
            error: function(data) {
                console.error(data);
            }
        });
    });



    $('#nav-side-site-language').on('change', function() {
        let languageCode = $(this).val();
        $('html').attr('lang', languageCode);
        $.ajax({
            method: 'GET',
            url: "{{ route('language') }}",
            data: {
                language_code: languageCode
            },
            success: function(data) {
                if (data.status === 'success') {
                    window.location.href = "{{ url('/') }}";
                }
            },
            error: function(data) {
                console.error(data);
            }
        });
    });

            /** Subscribe Newsletter**/
            $('.newsletter-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('subscribe-newsletter') }}",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.newsletter-button').text('loading...');
                        $('.newsletter-button').attr('disabled', true);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                            $('.newsletter-form')[0].reset();
                            $('.newsletter-button').text('sign up');

                            $('.newsletter-button').attr('disabled', false);
                        }
                    },
                    error: function(data) {
                        $('.newsletter-button').text('sign up');
                        $('.newsletter-button').attr('disabled', false);

                        if (data.status === 422) {
                            let errors = data.responseJSON.errors;
                            $.each(errors, function(index, value) {
                                Toast.fire({
                                    icon: 'error',
                                    title: value[0]
                                })
                            })
                        }
                    }
                })
            })
        })


    </script>



    @stack('content')

</body>

</html>
