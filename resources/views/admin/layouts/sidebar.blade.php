<div class="navbar-bg"></div>
<!-- Navbar Start -->
@include('admin.layouts.navbar')
<!-- Navbar End -->

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset($settings['site_logo']) }}" class="img-fluid logo" width="50%">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('admin.Dashboard') }}</li>

            <li class="{{ setSidebarActive(['admin.dashboard']) }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>{{ __('admin.Dashboard Blog') }}</span></a>
            </li>

            @if (canAccess(['Dashboard Utama']))
                <li class="{{ setSidebarActive(['admin.dashboard-utama.*']) }}"><a class="nav-link"
                        href="{{ route('admin.dashboard-utama.index') }}"><i class="fas fa-fire"></i>
                        <span>{{ __('admin.Dashboard Utama') }}</span></a></li>
            @endif

            @if (canAccess(['Dashboard Keuangan']))
                <li class="{{ setSidebarActive(['admin.laporan-keuangan.index']) }}">
                    <a class="nav-link" href="{{ route('admin.keuangan.AdminDashboard') }}"> <i
                            class="fas fa-fire"></i> {{ __('Dashboard Keuangan') }}</a>
                </li>
            @endif

            @if (canAccess(['Dashboard Kanvasing']))
                <li class="{{ setSidebarActive(['admin.dashboard-kanvasing.kanvasing']) }}">
                    <a class="nav-link" href="{{ route('admin.dashboard-kanvasing.kanvasing') }}"> <i
                            class="fas fa-fire"></i>{{ __('Dashboard Kanvasing') }}</a>
                </li>
            @endif


            @if (canAccess(['Keuangan Pusat']))
                <li class="menu-header">{{ __('admin.Keuangan') }}</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-money-bill-wave"></i>
                        <span>{{ __('Keuangan') }}</span></a>
                    <ul class="dropdown-menu">
                        @if (canAccess(['Anggaran index', 'Anggaran create', 'Anggaran update', 'Anggaran delete']))
                            <li class="{{ setSidebarActive(['admin.anggaran.index']) }}">
                                <a class="nav-link"
                                    href="{{ route('admin.anggaran.index') }}">{{ __('Manajemen Anggaran') }}</a>
                            </li>
                        @endif


                        @if (canAccess([
                                'Jenis Pembiayaan index',
                                'Jenis Pembiayaan create',
                                'Jenis Pembiayaan update',
                                'Jenis Pembiayaan delete',
                            ]))
                            <li class="{{ setSidebarActive(['admin.jenis-pembiayaan.index']) }}">
                                <a class="nav-link"
                                    href="{{ route('admin.jenis-pembiayaan.index') }}">{{ __('Jenis Pembiayaan') }}</a>
                            </li>
                        @endif

                        @if (canAccess([
                                'Detail Pembiayaan index',
                                'Detail Pembiayaan create',
                                'Detail Pembiayaan update',
                                'Detail Pembiayaan delete',
                            ]))
                            <li class="{{ setSidebarActive(['admin.keuangan.detail_pembiayaan.index']) }}">
                                <a class="nav-link"
                                    href="{{ route('admin.keuangan.detail_pembiayaan.index') }}">{{ __('Detail Pembiayaan') }}</a>
                            </li>
                        @endif


                        @if (canAccess(['Periode index', 'Periode create', 'Periode update', 'Periode delete']))
                            <li class="{{ setSidebarActive(['admin.periode.index']) }}">
                                <a class="nav-link"
                                    href="{{ route('admin.periode.index') }}">{{ __('Periode Pembiayaan') }}</a>
                            </li>
                        @endif

                        @if (canAccess([
                                'Penggunaan Anggaran index',
                                'Penggunaan Anggaran create',
                                'Penggunaan Anggaran update',
                                'Penggunaan Anggaran delete',
                            ]))
                            <li class="{{ setSidebarActive(['admin.keuangan.penggunaan_anggaran.index']) }}">
                                <a class="nav-link"
                                    href="{{ route('admin.keuangan.penggunaan_anggaran.index') }}">{{ __('Penggunaan Anggaran') }}</a>
                            </li>
                        @endif

                        @if (canAccess([
                                'Laporan Pembiayaan index',
                                'Laporan Pembiayaan create',
                                'Laporan Pembiayaan update',
                                'Laporan Pembiayaan delete',
                            ]))
                            <li class="{{ setSidebarActive(['admin.keuangan.laporan_pembayaran.index']) }}">
                                <a class="nav-link"
                                    href="{{ route('admin.keuangan.laporan_pembayaran.index') }}">{{ __('Laporan Pembiayaan') }}</a>
                            </li>
                        @endif

                        @if (canAccess([
                                'Gaji Tim',
                            ]))
                            <li class="{{ setSidebarActive(['admin.keuangan.gaji.index']) }}">
                                <a class="nav-link"
                                    href="{{ route('admin.keuangan.gaji.index') }}">{{ __('Gaji Tim') }}</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif




            @if (canAccess(['Tim Pusat']))

                <li class="menu-header">{{ __('admin.TIM PUSAT') }}</li>

                {{-- TIM PUSAT DS --}}
                @if (canAccess(['Tim Pusat DS']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpusatds.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('Tim DS') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua Tim --}}
                            @if (canAccess(['Tim Pusat DS Ketua Tim Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatds.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Admin --}}
                            @if (canAccess(['Tim Pusat DS Admin Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatds.admin.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Admin') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Keuangan DS --}}
                            @if (canAccess([
                                    'Tim Pusat DS Keuangan Index',
                                    'Tim Pusat DS Keuangan Create',
                                    'Tim Pusat DS Keuangan Update',
                                    'Tim Pusat DS Keuangan Delete',
                                ]))
                                <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="{{ setSidebarActive(['admin.timpusatds.index']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.timpusatds.index') }}">{{ __('Keuangan DS') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- TIM PUSAT WISATA --}}
                @if (canAccess(['Tim Pusat Wisata']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpusatwisata.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('Tim Wisata') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua Tim --}}
                            @if (canAccess(['Tim Pusat Wisata Ketua Tim Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatwisata.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Admin --}}
                            @if (canAccess(['Tim Pusat Wisata Admin Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatwisata.admin.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Admin') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Keuangan DS --}}
                            @if (canAccess([
                                    'Tim Pusat Wisata Keuangan Index',
                                    'Tim Pusat Wisata Keuangan Create',
                                    'Tim Pusat Wisata Keuangan Update',
                                    'Tim Pusat Wisata Keuangan Delete',
                                ]))
                                <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="{{ setSidebarActive(['admin.timpusatwisata.index']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.timpusatwisata.index') }}">{{ __('Keuangan Wisata') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- TIM PUSAT PKH --}}
                @if (canAccess(['Tim Pusat PKH']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpusatpkh.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('Tim PKH') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua Tim --}}
                            @if (canAccess(['Tim Pusat PKH Ketua Tim Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatpkh.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Admin --}}
                            @if (canAccess(['Tim Pusat PKH Admin Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatpkh.admin.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Admin') }}</a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Keuangan DS --}}
                            @if (canAccess([
                                    'Tim Pusat PKH Keuangan Index',
                                    'Tim Pusat PKH Keuangan Create',
                                    'Tim Pusat PKH Keuangan Update',
                                    'Tim Pusat PKH Keuangan Delete',
                                ]))
                                <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="{{ setSidebarActive(['admin.timpusatpkh.index']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.timpusatpkh.index') }}">{{ __('Keuangan PKH') }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- TIM PUSAT MUHAMMADIYAH --}}
                @if (canAccess(['Tim Pusat Muhammadiyah']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpusatmm.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('Tim Muhammadiyah') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua Tim --}}
                            @if (canAccess(['Tim Pusat Muhammadiyah Ketua Tim Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatmm.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Admin --}}
                            @if (canAccess(['Tim Pusat Muhammadiyah Admin Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatmm.admin.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Admin') }}</a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Keuangan DS --}}
                            @if (canAccess([
                                    'Tim Pusat Muhammadiyah Keuangan Index',
                                    'Tim Pusat Muhammadiyah Keuangan Create',
                                    'Tim Pusat Muhammadiyah Keuangan Update',
                                    'Tim Pusat Muhammadiyah Keuangan Delete',
                                ]))
                                <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="{{ setSidebarActive(['admin.timpusatmm.index']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.timpusatmm.index') }}">{{ __('Keuangan Muhammadiyah') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- TIM PUSAT AISYIAH --}}
                @if (canAccess(['Tim Pusat Aisyiah']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpusatAisyiah.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('TIM Aisyiah') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua Tim --}}
                            @if (canAccess(['Tim Pusat Aisyiah Ketua Tim Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatAisyiah.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Admin --}}
                            @if (canAccess(['Tim Pusat Aisyiah Admin Dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpusatAisyiah.admin.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Admin') }}</a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Keuangan DS --}}
                            @if (canAccess([
                                    'Tim Pusat Aisyiah Keuangan Index',
                                    'Tim Pusat Aisyiah Keuangan Create',
                                    'Tim Pusat Aisyiah Keuangan Update',
                                    'Tim Pusat Aisyiah Keuangan Delete',
                                ]))
                                <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                                <li class="{{ setSidebarActive(['admin.timpusatAisyiah.index']) }}">
                                    <a class="nav-link"
                                        href="{{ route('admin.timpusatAisyiah.index') }}">{{ __('Keuangan Aisyiah') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
            @endif



            @if (canAccess(['Tim Inti']))
                <li class="menu-header">{{ __('admin.TIM INTI') }}</li>

                @if (canAccess(['Tim Inti Ds']))
                    <li class="dropdown {{ setSidebarActive(['admin.timds.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('TIM DS') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua DS --}}
                            @if (canAccess(['Tim Inti Ketua DS dashboard']))
                                <li class="dropdown {{ setSidebarActive(['admin.timds.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Wilayah --}}
                            @if (canAccess(['koordinator wilayah DS']))
                                <li class="dropdown {{ setSidebarActive(['admin.timds.koordinator.wilayah.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Wilayah') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timds.koordinator.wilayah.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timds.koordinator.wilayah.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Kecamatan --}}
                            @if (canAccess(['koordinator kecamatan DS']))
                                <li class="dropdown {{ setSidebarActive(['admin.timds.koordinator.kecamatan.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Kecamatan') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timds.koordinator.kecamatan.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timds.koordinator.kecamatan.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Nagari --}}
                            @if (canAccess(['koordinator nagari DS']))
                                <li class="dropdown {{ setSidebarActive(['admin.timds.koordinator.nagari.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Nagari') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timds.koordinator.nagari.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timds.koordinator.nagari.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (canAccess(['Tim Inti PKH']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpkh.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('TIM PKH') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua pkh --}}
                            {{-- @if (canAccess(['ketua pkh']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.timpkh.ketua.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.timpkh.ketua.laporan']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.ketua.laporan') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}

                            {{-- Koordinator Wilayah --}}
                            @if (canAccess(['koordinator pkh wilayah']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.wilayah.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Wilayah') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.wilayah.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.wilayah.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Kecamatan --}}
                            {{-- @if (canAccess(['koordinator pkh kecamatan']))
                                <li
                                    class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Kecamatan') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.kecamatan.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.laporan']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.kecamatan.laporan') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}

                            {{-- Koordinator Nagari --}}
                            {{-- @if (canAccess(['koordinator pkh nagari']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.nagari.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Nagari') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.nagari.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.nagari.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.nagari.laporan']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.nagari.laporan') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}

                        </ul>
                    </li>
                @endif

                @if (canAccess(['Tim Inti MUHAMMADIYAH']))
                    <li class="dropdown {{ setSidebarActive(['admin.timmm.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('TIM MUHAMMADIYAH') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua mm --}}
                            @if (canAccess(['ketua mm']))
                                <li class="dropdown {{ setSidebarActive(['admin.timmm.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.timmm.ketua.laporan']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timmm.ketua.laporan') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Wilayah --}}
                            @if (canAccess(['koordinator mm wilayah']))
                                <li class="dropdown {{ setSidebarActive(['admin.timmm.koordinator.wilayah.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Wilayah') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timmm.koordinator.wilayah.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timmm.koordinator.wilayah.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Kecamatan --}}
                            @if (canAccess(['koordinator mm kecamatan']))
                                <li class="dropdown {{ setSidebarActive(['admin.timmm.koordinator.kecamatan.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Kecamatan') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timmm.koordinator.kecamatan.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timmm.koordinator.kecamatan.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Nagari --}}
                            @if (canAccess(['koordinator mm nagari']))
                                <li class="dropdown {{ setSidebarActive(['admin.timmm.koordinator.nagari.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Nagari') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timmm.koordinator.nagari.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timmm.koordinator.nagari.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                @if (canAccess(['Tim Inti AISYIAH']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpkh.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('TIM AISYIAH') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua Aisyiah --}}
                            @if (canAccess(['ketua Aisyiah']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Wilayah --}}
                            @if (canAccess(['koordinator Aisyiah wilayah']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.wilayah.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Wilayah') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.wilayah.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.wilayah.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Kecamatan --}}
                            @if (canAccess(['koordinator Aisyiah kecamatan']))
                                <li
                                    class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Kecamatan') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.kecamatan.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Nagari --}}
                            {{-- @if (canAccess(['koordinator Aisyiah nagari']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.nagari.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Nagari') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.nagari.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.nagari.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.nagari.laporan']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.nagari.laporan') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}

                        </ul>
                    </li>
                @endif

                @if (canAccess(['Tim Inti Wisata']))
                    <li class="dropdown {{ setSidebarActive(['admin.timwisata.*']) }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-users"></i>
                            <span>{{ __('TIM WISATA') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @if (canAccess(['Koordinator Wilayah Wisata']))
                                <li
                                    class="dropdown {{ setSidebarActive(['admin.timwisata.koordinator.wilayah.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">
                                        {{ __('Koordinator Wilayah') }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.ketua.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.ketua.dashboard') }}">
                                                {{ __('Dashboard') }}
                                            </a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">
                                                {{ __('Laporan') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            @if (canAccess(['Koordinator Kecematan Wisata']))
                                <li
                                    class="dropdown {{ setSidebarActive(['admin.timwisata.koordinator.kecematan.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">
                                        {{ __('Koordinator Kecematan') }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timwisata.koordinator.kecematan.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timwisata.koordinator.kecematan.dashboard') }}">
                                                {{ __('Dashboard') }}
                                            </a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">
                                                {{ __('Laporan') }}
                                            </a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timwisata.admin.kecematan.InputData']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timwisata.admin.kecematan.InputData') }}">
                                                {{ __('Input Data Wisata') }}
                                            </a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timwisata.admin.kecematan.absensi']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timwisata.admin.kecematan.absensi') }}">
                                                {{ __('Absesnsi Wisata') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            @if (canAccess(['Koordinator Admin Wisata']))
                                <li class="dropdown {{ setSidebarActive(['admin.timwisata.admin.kecematan.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">
                                        {{ __('Admin Kecematan') }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timwisata.admin.kecematan.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timwisata.admin.kecematan.dashboard') }}">
                                                {{ __('Dashboard') }}
                                            </a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">
                                                {{ __('Laporan') }}
                                            </a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timwisata.admin.kecematan.InputData']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timwisata.admin.kecematan.InputData') }}">
                                                {{ __('Input Data Wisata') }}
                                            </a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timwisata.admin.kecematan.absensi']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timwisata.admin.kecematan.absensi') }}">
                                                {{ __('Absesnsi Wisata') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (canAccess(['Tim Inti PARPOL']))
                    <li class="dropdown {{ setSidebarActive(['admin.timpkh.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                            <span>{{ __('TIM PARPOL') }}</span></a>
                        <ul class="dropdown-menu">

                            {{-- Ketua pkh --}}
                            @if (canAccess(['ketua PARPOL']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.ketua.*']) }}">
                                    <a href="#" class="nav-link has-dropdown">{{ __('Ketua Tim') }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="{{ setSidebarActive(['admin.timpkh.ketua.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.ketua.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Wilayah --}}
                            @if (canAccess(['koordinator PARPOL wilayah']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.wilayah.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Wilayah') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.wilayah.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.wilayah.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="{{ setSidebarActive(['admin.reports.index']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.reports.index') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            {{-- Koordinator Kecamatan --}}
                            {{-- @if (canAccess(['koordinator PARPOL kecamatan']))
                                <li
                                    class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Kecamatan') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.kecamatan.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.kecamatan.laporan']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.kecamatan.laporan') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}

                            {{-- Koordinator Nagari --}}
                            {{-- @if (canAccess(['koordinator PARPOL nagari']))
                                <li class="dropdown {{ setSidebarActive(['admin.timpkh.koordinator.nagari.*']) }}">
                                    <a href="#"
                                        class="nav-link has-dropdown">{{ __('Koordinator Nagari') }}</a>
                                    <ul class="dropdown-menu">
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.nagari.dashboard']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.nagari.dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        <li
                                            class="{{ setSidebarActive(['admin.timpkh.koordinator.nagari.laporan']) }}">
                                            <a class="nav-link"
                                                href="{{ route('admin.timpkh.koordinator.nagari.laporan') }}">{{ __('Laporan') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                @endif
            @endif



            @if (canAccess(['Blog show']))
                <li class="menu-header">{{ __('admin.Blog') }}</li>
                @if (canAccess(['category index', 'category create', 'category udpate', 'category delete']))
                    <li class="{{ setSidebarActive(['admin.category.*']) }}"><a class="nav-link"
                            href="{{ route('admin.category.index') }}"><i class="fas fa-list"></i>
                            <span>{{ __('admin.Category') }}</span></a></li>
                @endif

                @if (canAccess(['news index']))
                    <li class="dropdown {{ setSidebarActive(['admin.news.*', 'admin.pending.news']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-newspaper"></i>
                            <span>{{ __('admin.News') }}</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ setSidebarActive(['admin.news.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.news.index') }}">{{ __('admin.All News') }}</a></li>

                            <li class="{{ setSidebarActive(['admin.pending.news']) }}"><a class="nav-link"
                                    href="{{ route('admin.pending.news') }}">{{ __('admin.Pending News') }}</a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if (canAccess(['about index', 'contact index']))
                    <li class="dropdown {{ setSidebarActive(['admin.about.*', 'admin.contact.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i>
                            <span>{{ __('admin.Pages') }}</span></a>
                        <ul class="dropdown-menu">
                            @if (canAccess(['about index']))
                                <li class="{{ setSidebarActive(['admin.about.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.about.index') }}">{{ __('admin.About Page') }}</a>
                                </li>
                            @endif
                            @if (canAccess(['conatact index']))
                                <li class="{{ setSidebarActive(['admin.contact.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.contact.index') }}">{{ __('admin.Contact Page') }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (canAccess(['social count index']))
                    <li class="{{ setSidebarActive(['admin.social-count.*']) }}"><a class="nav-link"
                            href="{{ route('admin.social-count.index') }}"><i class="fas fa-hashtag"></i>
                            <span>{{ __('admin.Social Count') }}</span></a></li>
                @endif

                @if (canAccess(['contact message index']))
                    <li class="{{ setSidebarActive(['admin.contact-message.*']) }}"><a class="nav-link"
                            href="{{ route('admin.contact-message.index') }}"><i class="fas fa-id-card-alt"></i>
                            <span>{{ __('admin.Contact Messages') }} </span>
                            @if ($unReadMessages > 0)
                                <i class="badge bg-danger"
                                    style="color:
                        #fff">{{ $unReadMessages }}</i>
                            @endif
                        </a></li>
                @endif

                @if (canAccess(['home section index']))
                    <li class="{{ setSidebarActive(['admin.home-section-setting.*']) }}"><a class="nav-link"
                            href="{{ route('admin.home-section-setting.index') }}"><i class="fas fa-wrench"></i>
                            <span>{{ __('admin.Home Section Setting') }}</span></a></li>
                @endif

                @if (canAccess(['advertisement index']))
                    <li class="{{ setSidebarActive(['admin.ad.*']) }}"><a class="nav-link"
                            href="{{ route('admin.ad.index') }}"><i class="fas fa-ad"></i>
                            <span>{{ __('admin.Advertisement') }}</span></a></li>
                @endif


                @if (canAccess(['subscribers index']))
                    <li class="{{ setSidebarActive(['admin.subscribers.*']) }}"><a class="nav-link"
                            href="{{ route('admin.subscribers.index') }}"><i class="fas fa-users"></i>
                            <span>{{ __('admin.Subscribers') }}</span></a></li>
                @endif

                @if (canAccess(['footer index']))
                    <li
                        class="dropdown
                        {{ setSidebarActive([
                            'admin.social-link.*',
                            'admin.footer-info.*',
                            'admin.footer-grid-one.*',
                            'admin.footer-grid-three.*',
                            'admin.footer-grid-two.*',
                        ]) }}
                        ">
                        <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i>
                            <span>{{ __('admin.Footer') }} {{ __('admin.Setting') }}</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ setSidebarActive(['admin.social-link.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.social-link.index') }}">{{ __('admin.Social Links') }}</a>
                            </li>
                            <li class="{{ setSidebarActive(['admin.footer-info.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.footer-info.index') }}">{{ __('admin.Footer Info') }}</a>
                            </li>
                            <li class="{{ setSidebarActive(['admin.footer-grid-one.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.footer-grid-one.index') }}">{{ __('admin.Footer Grid One') }}</a>
                            </li>
                            <li class="{{ setSidebarActive(['admin.footer-grid-two.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.footer-grid-two.index') }}">{{ __('admin.Footer Grid Two') }}</a>
                            </li>
                            <li class="{{ setSidebarActive(['admin.footer-grid-three.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.footer-grid-three.index') }}">{{ __('admin.Footer Grid Three') }}</a>
                            </li>

                        </ul>
                    </li>
                @endif
            @endif



            @if (canAccess(['Setting']))
                <li class="menu-header">{{ __('admin.Setting') }}</li>


                @if (canAccess(['tim index', 'tim create', 'tim udpate', 'tim delete']))
                    <li class="{{ setSidebarActive(['admin.tims.*']) }}"><a class="nav-link"
                            href="{{ route('admin.tims.index') }}"><i class="fas fa-list"></i>
                            <span>{{ __('admin.Tim') }}</span></a></li>
                @endif


                @if (canAccess(['jabatan index', 'jabatan create', 'jabatan udpate', 'jabatan delete']))
                    <li class="{{ setSidebarActive(['admin.jabatan.*']) }}"><a class="nav-link"
                            href="{{ route('admin.jabatan.index') }}"><i class="fas fa-list"></i>
                            <span>{{ __('admin.Jabatan') }}</span></a></li>
                @endif



                @if (canAccess(['access management index']))
                    <li class="dropdown{{ setSidebarActive(['admin.role.*', 'admin.role-users.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-shield"></i>
                            <span>{{ __('admin.Access Management') }}</span></a>
                        <ul class="dropdown-menu">

                            <li class="{{ setSidebarActive(['admin.role-users.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.role-users.index') }}">{{ __('admin.Role Users') }}</a>
                            </li>

                            <li class="{{ setSidebarActive(['admin.role.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.role.index') }}">{{ __('admin.Roles and Permissions') }}</a>
                            </li>

                            <li class="{{ setSidebarActive(['admin.permissions.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.permissions.index') }}">{{ __('admin.Permissions') }}</a>
                            </li>
                            @if (canAccess(['user register']))
                                <li class="{{ setSidebarActive(['admin.register.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.register.create') }}">
                                        <span>{{ __('admin.Tim Lapangan') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if (canAccess(['setting index']))
                    <li class="{{ setSidebarActive(['admin.setting.*']) }}"><a class="nav-link"
                            href="{{ route('admin.setting.index') }}"><i class="fas fa-cog"></i>
                            <span>{{ __('admin.Settings') }}</span></a></li>
                @endif

                @if (canAccess(['languages index']))
                    <li
                        class="dropdown {{ setSidebarActive(['admin.frontend-localization.index', 'admin.admin-localization.index', 'admin.language.*']) }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-language"></i>
                            <span>{{ __('admin.Localization') }}</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ setSidebarActive(['admin.language.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.language.index') }}">
                                    <span>{{ __('admin.Languages') }}</span></a></li>

                            <li class="{{ setSidebarActive(['admin.frontend-localization.index']) }}"><a
                                    class="nav-link" href="{{ route('admin.frontend-localization.index') }}">
                                    <span>{{ __('admin.Frontend Lang') }}</span></a></li>

                            <li class="{{ setSidebarActive(['admin.admin-localization.index']) }}"><a
                                    class="nav-link" href="{{ route('admin.admin-localization.index') }}">
                                    <span>{{ __('admin.Admin Lang') }}</span></a></li>
                        </ul>
                    </li>
                @endif
            @endif


        </ul>
    </aside>
</div>
