<div class="menu-header">
    <a href="#" data-toggle-theme class="border-right-0">
        <i class="fa font-12 color-yellow1-dark fa-lightbulb"></i>
    </a>
    <a href="#" data-menu="menu-highlights" class="border-right-0">
        <i class="fa font-12 color-green1-dark fa-brush"></i>
    </a>
    <a href="#" data-menu="menu-share" class="border-right-0">
        <i class="fa font-12 color-red2-dark fa-share-alt"></i>
    </a>
    <a href="#" class="border-right-0">
        <i class="fa font-12 color-blue2-dark fa-cog"></i>
    </a>
    <a href="#" class="close-menu border-right-0">
        <i class="fa font-12 color-red2-dark fa-times"></i>
    </a>
</div>



<div class="menu-items">
    <h5 class="text-uppercase opacity-20 font-12 pl-3">
        Menu
    </h5>
    {{--
    <a href="#" data-submenu="sub-contact">
        <i data-feather="mail" data-feather-line="1" data-feather-size="16" data-feather-color="blue2-dark"
            data-feather-bg="blue2-fade-dark"></i>
        <span>
            @if (session('lang') === 'id')
                {{ 'Kontak' }}
    @else
    {{ $translate->translate('Contact') }}
    @endif
    </span>
    <strong class="badge bg-highlight color-white">1</strong>
    <i class="fa fa-circle"></i>
    </a>
    <div id="sub-contact" class="submenu">
        <a href="contact.blade.php" id="nav-contact">
            <i class="fa fa-envelope color-blue2-dark font-16 opacity-30"></i>
            <span>
                @if (session('lang') === 'id')
                {{ 'Email' }}
                @else
                {{ $translate->translate('Email') }}
                @endif
            </span>
            <i class="fa fa-circle"></i>
        </a>
        <a href="#">
            <i class="fa fa-phone color-green1-dark font-16 opacity-50"></i>
            <span>
                @if (session('lang') === 'id')
                {{ 'Telepon' }}
                @else
                {{ $translate->translate('Phone') }}
                @endif
            </span>
            <i class="fa fa-circle"></i>
        </a>
        <a href="#">
            <i class="fab fa-whatsapp color-whatsapp font-16 opacity-30"></i>
            <span>
                @if (session('lang') === 'id')
                {{ 'WhatsApp' }}
                @else
                {{ $translate->translate('WhatsApp') }}
                @endif
            </span>
            <i class="fa fa-circle"></i>
        </a>
    </div> --}}

    @if (Route::has('login'))
    <nav class="-mx-3 flex flex-1 justify-end">
        @auth

        <a href="{{ route('profile.edit') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            <!-- Login Icon -->
            <i class="fa fa-sign-in-alt"></i>
            <span>Profile</span>
        </a>


        <a href="#" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <!-- Logout Icon -->
            <i class="fa fa-sign-out-alt"></i>
            <span>
                @if (session('lang') === 'id')
                {{ 'Keluar' }}
                @else
                {{ __('Log Out') }}
                @endif
            </span>
        </a>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
        @else
        <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            <!-- Login Icon -->
            <i class="fa fa-sign-in-alt"></i>
            <span>Log in</span>
        </a>

        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            <!-- Register Icon -->
            <i class="fa fa-user-plus"></i>
            <span>Register</span>
        </a>
        @endif
        @endauth
    </nav>
    @endif




</div>

<div class="text-center pt-2">
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-facebook"><i class="fab fa-facebook"></i></a>
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-twitter"><i class="fab fa-twitter"></i></a>
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-instagram"><i class="fab fa-instagram"></i></a>
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-linkedin"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="icon icon-xs rounded-s bg-whatsapp"><i class="fab fa-whatsapp"></i></a>
    <p class="mb-0 pt-3 font-10 opacity-30">
        Hak Cipta <span class="copyright-year"></span> Enabled. Semua hak dilindungi.
    </p>
</div>
