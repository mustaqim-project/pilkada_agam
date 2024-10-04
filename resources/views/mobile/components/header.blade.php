<!-- Header and footer bar go here -->
<div class="header header-fixed header-auto-show header-logo-app">
    <!-- Logo -->
    <a href="{{ url('/') }}">
        <img class="header-title"   src="{{ asset('mobile/images/logo.png') }}" alt="Logo">
    </a>

    <!-- Menu Toggle -->
    <a href="#" data-menu="menu-main" class="header-icon header-icon-1">
        <i class="fas fa-bars"></i>
    </a>

    <!-- Toggle Theme to Light -->
    <a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-dark" title="Switch to Light Theme">
        <i class="fas fa-sun"></i>
    </a>

    <!-- Toggle Theme to Dark -->
    <a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-light" title="Switch to Dark Theme">
        <i class="fas fa-moon"></i>
    </a>

    <!-- Highlights Menu -->
    <a href="#" data-menu="menu-highlights" class="header-icon header-icon-3">
        <i class="fas fa-brush"></i>
    </a>
</div>
