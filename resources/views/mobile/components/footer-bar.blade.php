<style>
    #footer-bar {
        display: flex;
        justify-content: space-around; /* Atur posisi agar Beranda di tengah */
        align-items: center;
        background-color: #f8f9fa; /* Warna latar belakang sesuai keinginan */
        padding: 10px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    #footer-bar a {
        text-align: center;
        flex: 1;
    }

    #footer-bar .active-nav {
        font-weight: bold;
    }

    #footer-bar i {
        display: block;
        margin-bottom: 5px;
    }
</style>

<div id="footer-bar" class="footer-bar-5">
    <a href="#">
        <i data-feather="bar-chart-2" data-feather-line="1" data-feather-size="21" data-feather-color="red2-dark" data-feather-bg="red2-fade-light"></i>
        <span>Analisis Suara</span>
    </a>
    <a href="#">
        <i data-feather="users" data-feather-line="1" data-feather-size="21" data-feather-color="green1-dark" data-feather-bg="green1-fade-light"></i>
        <span>Relawan</span>
    </a>
    <a href="/" class="active-nav">
        <i data-feather="home" data-feather-line="1" data-feather-size="21" data-feather-color="blue2-dark" data-feather-bg="blue2-fade-light"></i>
        <span>Beranda</span>
    </a>
    <a href="#">
        <i data-feather="file-text" data-feather-line="1" data-feather-size="21" data-feather-color="brown1-dark" data-feather-bg="brown1-fade-light"></i>
        <span>Laporan</span>
    </a>
    <a href="#">
        <i data-feather="user" data-feather-line="1" data-feather-size="21" data-feather-color="gray2-dark" data-feather-bg="gray2-fade-light"></i>
        <span>Profil</span>
    </a>
</div>

