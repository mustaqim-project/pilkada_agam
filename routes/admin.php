<?php

use App\Models\Setting;
use App\Models\FooterGridOne;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\TimController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AgamaController;
use App\Http\Controllers\Admin\TimDsController;
use App\Http\Controllers\Admin\TimMMController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TimPKHController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AnggaranController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\kebijakanController;
use App\Http\Controllers\Admin\FooterInfoController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\KanvasingDsController;
use App\Http\Controllers\Admin\KanvasingJjController;
use App\Http\Controllers\Admin\KanvasingMMController;
use App\Http\Controllers\Admin\SocialCountController;
use App\Http\Controllers\Admin\KanvasingPkhController;
use App\Http\Controllers\Admin\LocalizationController;
use App\Http\Controllers\Admin\FooterGridOneController;
use App\Http\Controllers\Admin\FooterGridTwoController;
use App\Http\Controllers\Admin\RolePermisionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\FooterGridThreeController;
use App\Http\Controllers\Admin\JenisPembiayaanController;
use App\Http\Controllers\Admin\KanvasingParpolController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\KanvasingAisyiahController;
use App\Http\Controllers\Admin\HomeSectionSettingController;
use App\Http\Controllers\Admin\AdminAuthenticationController;
use App\Http\Controllers\Admin\DashboardUtamaController;
use App\Http\Controllers\Admin\TimPusatController;
use App\Http\Controllers\Admin\TimPusatAisyiahController;
use App\Http\Controllers\Admin\TimPusatMMController;
use App\Http\Controllers\Admin\TimPusatPkhController;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DashLapKeuController;
use App\Http\Controllers\Admin\Wisata\KoordinatorWilayahController;
use App\Http\Controllers\Admin\Wisata\TimPusatWisataController;
use App\Http\Controllers\Admin\Wisata\AdminKecematanWisataController;
use App\Http\Controllers\Admin\Wisata\KoordinatorKecematanWisataController;
use App\Http\Controllers\Admin\Keuangan\DetailPembiayaanController;
use App\Http\Controllers\Admin\Keuangan\EmployeeController;
use App\Http\Controllers\Admin\Keuangan\LaporanPembayaranController;
use App\Http\Controllers\Admin\Keuangan\PenggajianController;
use App\Http\Controllers\Admin\Keuangan\PenggunaanAnggaranController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\KetuaDashboardController;




Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/users', [RegisteredUserController::class, 'create'])->name('register.create');

    // Proses penyimpanan data pengguna baru
    Route::post('/users', [RegisteredUserController::class, 'store'])->name('register.store');

    // Tampilkan form edit pengguna
    Route::get('/users/{user}/edit', [RegisteredUserController::class, 'edit'])->name('register.edit');

    // Proses update pengguna
    Route::put('/users/{user}', [RegisteredUserController::class, 'update'])->name('register.update');

    // Proses hapus pengguna
    Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('register.destroy');


    Route::get('login', [AdminAuthenticationController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthenticationController::class, 'handleLogin'])->name('handle-login');
    Route::post('logout', [AdminAuthenticationController::class, 'logout'])->name('logout');

    /** Reset passeord */
    Route::get('forgot-password', [AdminAuthenticationController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [AdminAuthenticationController::class, 'sendResetLink'])->name('forgot-password.send');

    Route::get('reset-password/{token}', [AdminAuthenticationController::class, 'resetPassword'])->name('reset-password');
    Route::post('reset-password', [AdminAuthenticationController::class, 'handleResetPassword'])->name('reset-password.send');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard-utama', [DashboardUtamaController::class, 'index'])->name('dashboard-utama.index');
    Route::get('dashboard-kanvasing', [DashboardUtamaController::class, 'kanvasing'])->name('dashboard-kanvasing.kanvasing');


    /**Profile Routes */
    Route::put('profile-password-update/{id}', [ProfileController::class, 'passwordUpdate'])->name('profile-password.update');
    Route::resource('profile', ProfileController::class);

    /** Language Route */
    Route::resource('language', LanguageController::class);

    /** Category Route */
    Route::resource('category', CategoryController::class);

    /** News Route */
    Route::get('fetch-news-category', [NewsController::class, 'fetchCategory'])->name('fetch-news-category');
    Route::get('toggle-news-status', [NewsController::class, 'toggleNewsStatus'])->name('toggle-news-status');
    Route::get('news-copy/{id}', [NewsController::class, 'copyNews'])->name('news-copy');
    Route::get('pending-news', [NewsController::class, 'pendingNews'])->name('pending.news');
    Route::put('approve-news', [NewsController::class, 'approveNews'])->name('approve.news');

    Route::resource('news', NewsController::class);

    /** Home Section Setting Route */
    Route::get('home-section-setting', [HomeSectionSettingController::class, 'index'])->name('home-section-setting.index');
    Route::put('home-section-setting', [HomeSectionSettingController::class, 'update'])->name('home-section-setting.update');

    /** Social Count Route */
    Route::resource('social-count', SocialCountController::class);

    /** Ad Route */
    Route::resource('ad', AdController::class);

    /** Subscriber Route */
    Route::resource('subscribers', SubscriberController::class);

    /** Social links Route */
    Route::resource('social-link', SocialLinkController::class);

    /** Footer Info Route */
    Route::resource('footer-info', FooterInfoController::class);

    /** Footer Grid One Route */
    Route::post('footer-grid-one-title', [FooterGridOneController::class, 'handleTitle'])->name('footer-grid-one-title');
    Route::resource('footer-grid-one', FooterGridOneController::class);

    /** Footer Grid Two Route */
    Route::post('footer-grid-two-title', [FooterGridTwoController::class, 'handleTitle'])->name('footer-grid-two-title');
    Route::resource('footer-grid-two', FooterGridTwoController::class);

    /** Footer Grid Two Route */
    Route::post('footer-grid-three-title', [FooterGridThreeController::class, 'handleTitle'])->name('footer-grid-three-title');
    Route::resource('footer-grid-three', FooterGridThreeController::class);

    /** About page Route */
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::put('about', [AboutController::class, 'update'])->name('about.update');

    /** kebijakan page Route */
    Route::get('kebijakan', [kebijakanController::class, 'index'])->name('kebijakan.index');
    Route::put('kebijakan', [kebijakanController::class, 'update'])->name('kebijakan.update');

    /** Contact page Route */
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::put('contact', [ContactController::class, 'update'])->name('contact.update');

    /** Contact Message Route */
    Route::get('contact-message', [ContactMessageController::class, 'index'])->name('contact-message.index');
    Route::post('contact-send-replay', [ContactMessageController::class, 'sendReplay'])->name('contact.send-replay');

    /** Settings Routes */
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    /** Settings Routes */
    Route::put('general-setting', [SettingController::class, 'updateGeneralSetting'])->name('general-setting.update');
    Route::put('seo-setting', [SettingController::class, 'updateSeoSetting'])->name('seo-setting.update');
    Route::put('appearance-setting', [SettingController::class, 'updateAppearanceSetting'])->name('appearance-setting.update');
    Route::put('microsoft-api-setting', [SettingController::class, 'updateMicrosoftApiSetting'])->name('microsoft-api-setting.update');

    /** Role and Permissions Routes */
    Route::get('role', [RolePermisionController::class, 'index'])->name('role.index');
    Route::get('role/create', [RolePermisionController::class, 'create'])->name('role.create');
    Route::post('role/create', [RolePermisionController::class, 'store'])->name('role.store');
    Route::get('role/{id}/edit', [RolePermisionController::class, 'edit'])->name('role.edit');
    Route::put('role/{id}/edit', [RolePermisionController::class, 'update'])->name('role.update');
    Route::delete('role/{id}/destory', [RolePermisionController::class, 'destory'])->name('role.destory');

    /** Admin User Routes */
    Route::resource('role-users', RoleUserController::class);
    Route::get('/get-atasan', [RoleUserController::class, 'getAtasan'])->name('get-atasan');

    /** Localization Routes */
    Route::get('admin-localization', [LocalizationController::class, 'adminIndex'])->name('admin-localization.index');
    Route::get('frontend-localization', [LocalizationController::class, 'frontnedIndex'])->name('frontend-localization.index');

    Route::post('extract-localize-string', [LocalizationController::class, 'extractLocalizationStrings'])->name('extract-localize-string');

    Route::post('update-lang-string', [LocalizationController::class, 'updateLangString'])->name('update-lang-string');

    Route::post('translate-string', [LocalizationController::class, 'translateString'])->name('translate-string');


    // Tim DS
    Route::prefix('timds')->name('timds.')->group(function () {

        // Ketua DS
        Route::prefix('ketua')->name('ketua.')->group(function () {
            Route::get('dashboard', [TimDSController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimDSController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Koordinator Wilayah
        Route::prefix('koordinator-wilayah')->name('koordinator.wilayah.')->group(function () {
            Route::get('dashboard', [TimDSController::class, 'koordinatorWilayahDashboard'])->name('dashboard');
            Route::get('laporan', [TimDSController::class, 'koordinatorWilayahLaporan'])->name('laporan');
        });

        // Koordinator Kecamatan
        Route::prefix('koordinator-kecamatan')->name('koordinator.kecamatan.')->group(function () {
            Route::get('dashboard', [TimDSController::class, 'koordinatorKecamatanDashboard'])->name('dashboard');
            Route::get('laporan', [TimDSController::class, 'koordinatorKecamatanLaporan'])->name('laporan');
        });

        // Koordinator Nagari
        Route::prefix('koordinator-nagari')->name('koordinator.nagari.')->group(function () {
            Route::get('dashboard', [TimDSController::class, 'koordinatorNagariDashboard'])->name('dashboard');
            Route::get('laporan', [TimDSController::class, 'koordinatorNagariLaporan'])->name('laporan');
        });
    });


    Route::prefix('timpkh')->name('timpkh.')->group(function () {

        // Ketua pkh
        Route::prefix('ketua')->name('ketua.')->group(function () {
            Route::get('dashboard', [TimPKHController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimPKHController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Koordinator Wilayah
        Route::prefix('koordinator-wilayah')->name('koordinator.wilayah.')->group(function () {
            Route::get('dashboard', [TimPKHController::class, 'koordinatorWilayahDashboard'])->name('dashboard');
            Route::get('laporan', [TimPKHController::class, 'koordinatorWilayahLaporan'])->name('laporan');
        });

        // Koordinator Kecamatan
        Route::prefix('koordinator-kecamatan')->name('koordinator.kecamatan.')->group(function () {
            Route::get('dashboard', [TimPKHController::class, 'koordinatorKecamatanDashboard'])->name('dashboard');
            Route::get('laporan', [TimPKHController::class, 'koordinatorKecamatanLaporan'])->name('laporan');
        });

        // Koordinator Nagari
        Route::prefix('koordinator-nagari')->name('koordinator.nagari.')->group(function () {
            Route::get('dashboard', [TimPKHController::class, 'koordinatorNagariDashboard'])->name('dashboard');
            Route::get('laporan', [TimPKHController::class, 'koordinatorNagariLaporan'])->name('laporan');
        });
    });



    Route::prefix('timmm')->name('timmm.')->group(function () {

        // Ketua mm
        Route::prefix('ketua')->name('ketua.')->group(function () {
            Route::get('dashboard', [TimMMController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimMMController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Koordinator Wilayah
        Route::prefix('koordinator-wilayah')->name('koordinator.wilayah.')->group(function () {
            Route::get('dashboard', [TimMMController::class, 'koordinatorWilayahDashboard'])->name('dashboard');
            Route::get('laporan', [TimMMController::class, 'koordinatorWilayahLaporan'])->name('laporan');
        });

        // Koordinator Kecamatan
        Route::prefix('koordinator-kecamatan')->name('koordinator.kecamatan.')->group(function () {
            Route::get('dashboard', [TimMMController::class, 'koordinatorKecamatanDashboard'])->name('dashboard');
            Route::get('laporan', [TimMMController::class, 'koordinatorKecamatanLaporan'])->name('laporan');
        });

        // Koordinator Nagari
        Route::prefix('koordinator-nagari')->name('koordinator.nagari.')->group(function () {
            Route::get('dashboard', [TimMMController::class, 'koordinatorNagariDashboard'])->name('dashboard');
            Route::get('laporan', [TimMMController::class, 'koordinatorNagariLaporan'])->name('laporan');
        });
    });

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{id}', [ReportController::class, 'show'])->name('reports.show');

    Route::resource('jabatan', JabatanController::class);
    Route::resource('tims', TimController::class);
    Route::resource('agamas', AgamaController::class);
    Route::resource('jenis-pembiayaan', JenisPembiayaanController::class);
    Route::resource('anggaran', AnggaranController::class);
    Route::resource('periode', PeriodeController::class);


    Route::prefix('keuangan')->as('keuangan.')->group(function () {
        Route::resource('penggunaan-anggaran', PenggunaanAnggaranController::class)->names([
            'index' => 'penggunaan_anggaran.index',
            'store' => 'penggunaan_anggaran.store',
            'edit' => 'penggunaan_anggaran.edit',
            'update' => 'penggunaan_anggaran.update',
            'destroy' => 'penggunaan_anggaran.destroy',
        ]);
        Route::resource('laporan-pembayaran', LaporanPembayaranController::class)->names([
            'index' => 'laporan_pembayaran.index',
            'store' => 'laporan_pembayaran.store',
            'update' => 'laporan_pembayaran.update',
            'destroy' => 'laporan_pembayaran.destroy',
        ]);

        Route::resource('detail-pembiayaan', DetailPembiayaanController::class)->names([
            'index' => 'detail_pembiayaan.index',
            'store' => 'detail_pembiayaan.store',
            'edit' => 'detail_pembiayaan.edit',
            'update' => 'detail_pembiayaan.update',
            'destroy' => 'detail_pembiayaan.destroy',
        ]);


        Route::resource('gaji', PenggajianController::class)->names([
            'index' => 'gaji.index',
            'store' => 'gaji.store',
            'update' => 'gaji.update',
            'destroy' => 'gaji.destroy',
        ]);

        Route::resource('employee', EmployeeController::class)->names([
            'store' => 'employee.store',
            'update' => 'employee.update',
            'destroy' => 'employee.destroy',
        ]);

    });
    // Route::resource('laporan-keuangan', LaporanKeuanganController::class);
    // Route::get('laporan-keuangan/keuangan', [LaporanKeuanganController::class, 'keuangan'])->name('laporan-keuangan.keuangan'); // Menambahkan route ini

    Route::get('laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan.index');
    Route::get('laporan-keuangan/keuangan', [LaporanKeuanganController::class, 'keuangan'])->name('laporan-keuangan.keuangan'); // Menambahkan route ini
    Route::post('laporan-keuangan', [LaporanKeuanganController::class, 'store'])->name('laporan-keuangan.store');
    Route::get('laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('laporan-keuangan.create');
    Route::get('laporan-keuangan/{id}', [LaporanKeuanganController::class, 'show'])->name('laporan-keuangan.show');
    Route::get('laporan-keuangan/{id}/edit', [LaporanKeuanganController::class, 'edit'])->name('laporan-keuangan.edit');
    Route::put('laporan-keuangan/{id}', [LaporanKeuanganController::class, 'update'])->name('laporan-keuangan.update');
    Route::patch('laporan-keuangan/{id}', [LaporanKeuanganController::class, 'update'])->name('laporan-keuangan.update');
    Route::delete('laporan-keuangan/{id}', [LaporanKeuanganController::class, 'destroy'])->name('laporan-keuangan.destroy');

    // Route Kanvasing DS
    Route::get('kanvasing-ds', [KanvasingDsController::class, 'indexAdmin'])->name('kanvasing-ds.indexAdmin');
    Route::post('kanvasing-ds/store', [KanvasingDsController::class, 'store'])->name('kanvasing-ds.store');
    Route::put('kanvasing-ds/update/{id}', [KanvasingDsController::class, 'update'])->name('kanvasing-ds.update');
    Route::delete('kanvasing-ds/destroy/{id}', [KanvasingDsController::class, 'destroy'])->name('kanvasing-ds.destroy');

    // Route Kanvasing PKH
    Route::get('kanvasing-pkh', [KanvasingPkhController::class, 'indexAdmin'])->name('kanvasing-pkh.indexAdmin');
    Route::post('kanvasing-pkh/store', [KanvasingPkhController::class, 'store'])->name('kanvasing-pkh.store');
    Route::put('kanvasing-pkh/update/{id}', [KanvasingPkhController::class, 'update'])->name('kanvasing-pkh.update');
    Route::delete('kanvasing-pkh/destroy/{id}', [KanvasingPkhController::class, 'destroy'])->name('kanvasing-pkh.destroy');

    // Route Kanvasing Mm
    Route::get('kanvasing-mm', [KanvasingMmController::class, 'indexAdmin'])->name('kanvasing-mm.indexAdmin');
    Route::post('kanvasing-mm/store', [KanvasingMmController::class, 'store'])->name('kanvasing-mm.store');
    Route::put('kanvasing-mm/update/{id}', [KanvasingMmController::class, 'update'])->name('kanvasing-mm.update');
    Route::delete('kanvasing-mm/destroy/{id}', [KanvasingMmController::class, 'destroy'])->name('kanvasing-mm.destroy');

    // Route Kanvasing Aisyiyah
    Route::get('kanvasing-aisyiah', [KanvasingAisyiahController::class, 'indexAdmin'])->name('kanvasing-aisyiah.indexAdmin');
    Route::post('kanvasing-aisyiah/store', [KanvasingAisyiahController::class, 'store'])->name('kanvasing-aisyiah.store');
    Route::put('kanvasing-aisyiah/update/{id}', [KanvasingAisyiahController::class, 'update'])->name('kanvasing-aisyiah.update');
    Route::delete('kanvasing-aisyiah/destroy/{id}', [KanvasingAisyiahController::class, 'destroy'])->name('kanvasing-aisyiah.destroy');

    // Route Kanvasing Parpol
    Route::get('kanvasing-parpol', [KanvasingParpolController::class, 'indexAdmin'])->name('kanvasing-parpol.indexAdmin');
    Route::post('kanvasing-parpol/store', [KanvasingParpolController::class, 'store'])->name('kanvasing-parpol.store');
    Route::put('kanvasing-parpol/update/{id}', [KanvasingParpolController::class, 'update'])->name('kanvasing-parpol.update');
    Route::delete('kanvasing-parpol/destroy/{id}', [KanvasingParpolController::class, 'destroy'])->name('kanvasing-parpol.destroy');


    // Route Kanvasing JJ
    Route::get('kanvasing-jj', [KanvasingJjController::class, 'indexAdmin'])->name('kanvasing-jj.indexAdmin');
    Route::post('kanvasing-jj/store', [KanvasingJjController::class, 'store'])->name('kanvasing-jj.store');
    Route::put('kanvasing-jj/update/{id}', [KanvasingJjController::class, 'update'])->name('kanvasing-jj.update');
    Route::delete('kanvasing-jj/destroy/{id}', [KanvasingJjController::class, 'destroy'])->name('kanvasing-jj.destroy');








    Route::resource('permissions', PermissionController::class);




    Route::group(['prefix' => 'timpusatds', 'as' => 'timpusatds.'], function () {
        // Route untuk Ketua Tim
        Route::group(['prefix' => 'ketua', 'as' => 'ketua.'], function () {
            Route::get('dashboard', [TimPusatController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Route untuk Admin
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('dashboard', [TimPusatController::class, 'adminDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatController::class, 'adminLaporan'])->name('laporan');
        });

        // Route untuk Keuangan DS
        Route::get('/', [TimPusatController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'timpusatpkh', 'as' => 'timpusatpkh.'], function () {
        // Route untuk Ketua Tim
        Route::group(['prefix' => 'ketua', 'as' => 'ketua.'], function () {
            Route::get('dashboard', [TimPusatPkhController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatPkhController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Route untuk Admin
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('dashboard', [TimPusatPkhController::class, 'adminDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatPkhController::class, 'adminLaporan'])->name('laporan');
        });

        // Route untuk Keuangan DS
        Route::get('/', [TimPusatPkhController::class, 'index'])->name('index');
    });





    Route::group(['prefix' => 'timpusatmm', 'as' => 'timpusatmm.'], function () {
        // Route untuk Ketua Tim
        Route::group(['prefix' => 'ketua', 'as' => 'ketua.'], function () {
            Route::get('dashboard', [TimPusatMMController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatMMController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Route untuk Admin
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('dashboard', [TimPusatMMController::class, 'adminDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatMMController::class, 'adminLaporan'])->name('laporan');
        });

        // Route untuk Keuangan DS
        Route::get('/', [TimPusatMMController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'timpusatAisyiah', 'as' => 'timpusatAisyiah.'], function () {
        // Route untuk Ketua Tim
        Route::group(['prefix' => 'ketua', 'as' => 'ketua.'], function () {
            Route::get('dashboard', [TimPusatAisyiahController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatAisyiahController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Route untuk Admin
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('dashboard', [TimPusatAisyiahController::class, 'adminDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatAisyiahController::class, 'adminLaporan'])->name('laporan');
        });

        // Route untuk Keuangan DS
        Route::get('/', [TimPusatMMController::class, 'index'])->name('index');
    });



    Route::group(['prefix' => 'timpusatwisata', 'as' => 'timpusatwisata.'], function () {
        // Route untuk Ketua Tim
        Route::group(['prefix' => 'ketua', 'as' => 'ketua.'], function () {
            Route::get('dashboard', [TimPusatWisataController::class, 'ketuaDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatWisataController::class, 'ketuaLaporan'])->name('laporan');
        });

        // Route untuk Admin
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('dashboard', [TimPusatWisataController::class, 'adminDashboard'])->name('dashboard');
            Route::get('laporan', [TimPusatWisataController::class, 'adminLaporan'])->name('laporan');
        });

        // Route untuk Keuangan DS
        Route::get('/', [TimPusatWisataController::class, 'index'])->name('index');
    });












    Route::resource('bank', BankController::class);



    Route::get('dashboard-Keuangan', [DashLapKeuController::class, 'index'])->name('keuangan.AdminDashboard');





    Route::prefix('timwisata/koordinator/wilayah')->group(function () {

        // Route untuk halaman dashboard Koordinator Wilayah
        Route::get('/dashboard', [KoordinatorWilayahController::class, 'dashboard'])
            ->name('timwisata.koordinator.wilayah.dashboard');

        // Route untuk halaman laporan Koordinator Wilayah
        Route::get('/laporan', [KoordinatorWilayahController::class, 'laporan'])
            ->name('timwisata.koordinator.wilayah.laporan');
    });

    Route::prefix('timwisata/koordinator/kecematan')->group(function () {

        // Route untuk halaman dashboard Koordinator Kecematan
        Route::get('/dashboard', [KoordinatorKecematanWisataController::class, 'dashboard'])
            ->name('timwisata.koordinator.kecematan.dashboard');

        // Route untuk halaman laporan Koordinator Kecematan
        Route::get('/laporan', [KoordinatorKecematanWisataController::class, 'laporan'])
            ->name('timwisata.koordinator.kecematan.laporan');
    });
    Route::prefix('timwisata/admin/kecematan')->group(function () {

        // Route untuk halaman dashboard Admin Kecematan
        Route::get('/dashboard', [AdminKecematanWisataController::class, 'dashboard'])
            ->name('timwisata.admin.kecematan.dashboard');

        // Route untuk halaman laporan Admin Kecematan
        Route::get('/laporan', [AdminKecematanWisataController::class, 'laporan'])
            ->name('timwisata.admin.kecematan.laporan');

        // Route untuk halaman input data Kanvasing
        Route::get('/inputdata', [AdminKecematanWisataController::class, 'Kanvasing'])
            ->name('timwisata.admin.kecematan.InputData');

        // Route untuk halaman absensi
        Route::get('/absensi', [AdminKecematanWisataController::class, 'Absensi'])
            ->name('timwisata.admin.kecematan.absensi');

        // Route untuk menyimpan data wisata
        Route::post('/wisata/store', [AdminKecematanWisataController::class, 'storeWisata'])
            ->name('timwisata.admin.kecematan.storeWisata');

        // Route untuk memperbarui status hadir
        Route::post('/wisata/toggle-hadir', [AdminKecematanWisataController::class, 'toggleHadir'])
            ->name('timwisata.admin.kecematan.toggleHadir');

        // Route untuk memperbarui data wisata
        Route::put('/wisata/update/{id}', [AdminKecematanWisataController::class, 'updateWisata'])
            ->name('timwisata.admin.kecematan.updateWisata');

        // Route untuk menghapus data wisata
        Route::delete('/wisata/delete/{id}', [AdminKecematanWisataController::class, 'destroy'])
            ->name('timwisata.admin.kecematan.deleteWisata');

        // Route untuk mengambil data kelurahan berdasarkan kecamatan
        Route::get('/wisata/kelurahans/{kecamatan_id}', [AdminKecematanWisataController::class, 'getKelurahans'])
            ->name('timwisata.admin.kecematan.getKelurahans');
    });




    Route::get('/ketua-dashboard', [KetuaDashboardController::class, 'kanvasingDashboard'])->name('ketua.dashboard');



});
