<?php

use App\Models\Setting;
use App\Models\FooterGridOne;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\TimDsController;
use App\Http\Controllers\Admin\TimMMController;
use App\Http\Controllers\Admin\TimPKHController;
use App\Http\Controllers\Admin\ContactController;
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
use App\Http\Controllers\Admin\SocialCountController;
use App\Http\Controllers\Admin\LocalizationController;
use App\Http\Controllers\Admin\FooterGridOneController;
use App\Http\Controllers\Admin\FooterGridTwoController;
use App\Http\Controllers\Admin\RolePermisionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\FooterGridThreeController;
use App\Http\Controllers\Admin\HomeSectionSettingController;
use App\Http\Controllers\Admin\AdminAuthenticationController;
use App\Http\Controllers\Admin\ReportController;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {


    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

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

    /** Localization Routes */
    Route::get('admin-localization', [LocalizationController::class, 'adminIndex'])->name('admin-localization.index');
    Route::get('frontend-localization', [LocalizationController::class, 'frontnedIndex'])->name('frontend-localization.index');

    Route::post('extract-localize-string', [LocalizationController::class, 'extractLocalizationStrings'])->name('extract-localize-string');

    Route::post('update-lang-string', [LocalizationController::class, 'updateLangString'])->name('update-lang-string');

    Route::post('translate-string', [LocalizationController::class, 'translateString'])->name('translate-string');



    // Anggaran
    Route::resource('anggaran', AnggaranController::class);


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
});
