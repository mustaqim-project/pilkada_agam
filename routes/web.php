<?php

use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\KanvasingDsController;
use App\Http\Controllers\Admin\KanvasingJjController;
use App\Http\Controllers\Admin\KanvasingMmController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Admin\KanvasingPkhController;
use App\Http\Controllers\Admin\KanvasingParpolController;
use App\Http\Controllers\Admin\KanvasingAisyiahController;



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('kanvasing-ds', [KanvasingDsController::class, 'index'])->name('kanvasing-ds.index');
    Route::post('kanvasing-ds/store', [KanvasingDsController::class, 'store'])->name('kanvasing-ds.store');
    Route::put('kanvasing-ds/update/{id}', [KanvasingDsController::class, 'update'])->name('kanvasing-ds.update');


    Route::get('kanvasing-pkh', [KanvasingPkhController::class, 'index'])->name('kanvasing-pkh.index');
    Route::post('kanvasing-pkh/store', [KanvasingPkhController::class, 'store'])->name('kanvasing-pkh.store');
    Route::put('kanvasing-pkh/update/{id}', [KanvasingPkhController::class, 'update'])->name('kanvasing-pkh.update');


    Route::get('kanvasing-mm', [KanvasingMmController::class, 'index'])->name('kanvasing-mm.index');
    Route::post('kanvasing-mm/store', [KanvasingMmController::class, 'store'])->name('kanvasing-mm.store');
    Route::put('kanvasing-mm/update/{id}', [KanvasingMmController::class, 'update'])->name('kanvasing-mm.update');

    Route::get('kanvasing-aisyiah', action: [KanvasingAisyiahController::class, 'index'])->name('kanvasing-aisyiah.index');
    Route::post('kanvasing-aisyiah/store', [KanvasingAisyiahController::class, 'store'])->name('kanvasing-aisyiah.store');
    Route::put('kanvasing-aisyiah/update/{id}', [KanvasingAisyiahController::class, 'update'])->name('kanvasing-aisyiah.update');


    Route::get('kanvasing-parpol', [KanvasingParpolController::class, 'index'])->name('kanvasing-parpol.index');
    Route::post('kanvasing-parpol/store', [KanvasingParpolController::class, 'store'])->name('kanvasing-parpol.store');
    Route::put('kanvasing-parpol/update/{id}', [KanvasingParpolController::class, 'update'])->name('kanvasing-parpol.update');


    Route::get('kanvasing-jj', [KanvasingJjController::class, 'index'])->name('kanvasing-jj.index');
    Route::post('kanvasing-jj/store', [KanvasingJjController::class, 'store'])->name('kanvasing-jj.store');
    Route::put('kanvasing-jj/update/{id}', [KanvasingJjController::class, 'update'])->name('kanvasing-jj.update');







});










require __DIR__ . '/auth.php';

Route::get('language', LanguageController::class)->name('language');

/** News Details Routes */
Route::get('news-details/{slug}', [HomeController::class, 'ShowNews'])->name('news-details');

/** News Details Routes */
Route::get('news', [HomeController::class, 'news'])->name('news');

/** News Comment Routes */
Route::post('news-comment', [HomeController::class, 'handleComment'])->name('news-comment');
Route::post('news-comment-replay', [HomeController::class, 'handleReplay'])->name('news-comment-replay');

Route::delete('news-comment-destroy', [HomeController::class, 'commentDestory'])->name('news-comment-destroy');

/** Newsletter Routes */
Route::post('subscribe-newsletter', [HomeController::class, 'SubscribeNewsLetter'])->name('subscribe-newsletter');

/** About Page Route */
Route::get('about', [HomeController::class, 'about'])->name('about');

/** kebijakan Page Route */
Route::get('kebijakan', [HomeController::class, 'kebijakan'])->name('kebijakan');
/** Contact Page Route */
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
/** Contact Page Route */
Route::post('contact', [HomeController::class, 'handleContactFrom'])->name('contact.submit');

// Auth::routes(['reset' => true]);


// use App\Models\News;
// use App\Models\Category;

// Route::get('/sitemap.xml', function () {
//     $news = News::all();
//     $categories = Category::all();

//     return response()->view('sitemap', compact('news', 'categories'))->header('Content-Type', 'text/xml');
// });
