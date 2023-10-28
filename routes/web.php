<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[\App\Http\Controllers\HomepageController::class,'index']);
Route::get('/about',[\App\Http\Controllers\HomepageController::class,'about']);
Route::get('/kontak',[\App\Http\Controllers\HomepageController::class,'kontak']);
Route::get('/kategori',[\App\Http\Controllers\HomepageController::class,'kategori']);
Route::get('/kategori', [\App\Http\Controllers\HomepageController::class,'kategori']);
Route::get('/kategori/{slug}', [\App\Http\Controllers\HomepageController::class,'kategoribyslug']);
Route::get('/produk', [\App\Http\Controllers\HomepageController::class,'produk']);
Route::get('/produk/{id}', [\App\Http\Controllers\HomepageController::class,'produkdetail']);
Route::get('/cari', [\App\Http\Controllers\HomepageController::class, 'produk']);
Route::get('/event/{slug}', [\App\Http\Controllers\HomepageController::class, 'event']);

Route::group(['prefix' => 'admin','middleware' => ['auth', 'role:admin',]], function() {
  Route::get('/', [\App\Http\Controllers\AdminController::class,'index']);
  Route::resource('profil',\App\Http\Controllers\UserController::class);
  Route::resource('kategori',\App\Http\Controllers\KategoriController::class);
  Route::resource('customer',\App\Http\Controllers\CustomerController::class);
  Route::resource('transaksi',\App\Http\Controllers\TransaksiController::class);
  Route::resource('slideshow',\App\Http\Controllers\SlideshowController::class);
  Route::resource('event', \App\Http\Controllers\EventController::class);
  Route::resource('about', \App\Http\Controllers\AboutController::class);
  Route::resource('kontak', \App\Http\Controllers\KontakController::class);

  Route::get('image',[\App\Http\Controllers\ImageController::class,'index']);
  Route::post('image',[\App\Http\Controllers\ImageController::class,'store']);
  Route::delete('image/{id}',[\App\Http\Controllers\ImageController::class,'destroy']);
  Route::post('imagekategori',[\App\Http\Controllers\KategoriController::class,'uploadimage']);
  Route::delete('imagekategori/{id}',[\App\Http\Controllers\KategoriController::class,'deleteimage']);
});

Route::group(['prefix' => 'seller','middleware' => ['auth', 'role:seller',]], function() {
    Route::get('/', [\App\Http\Controllers\DashboardController::class,'index']);
    Route::resource('profil',\App\Http\Controllers\UserController::class);
    Route::resource('produk',\App\Http\Controllers\ProdukController::class);
    Route::get('/laporan',[\App\Http\Controllers\LaporanController::class,'index']);
    Route::get('/proseslaporan',[\App\Http\Controllers\LaporanController::class,'proses']);
    Route::get('image',[\App\Http\Controllers\ImageController::class,'index']);
    Route::post('image',[\App\Http\Controllers\ImageController::class,'store']);
    Route::delete('image/{id}',[\App\Http\Controllers\ImageController::class,'destroy']);
    Route::post('imagekategori',[\App\Http\Controllers\KategoriController::class,'uploadimage']);
    Route::delete('imagekategori/{id}',[\App\Http\Controllers\KategoriController::class,'deleteimage']);
    Route::post('produkimage',[\App\Http\Controllers\ProdukController::class,'uploadimage']);
    Route::delete('produkimage/{id}',[\App\Http\Controllers\ProdukController::class,'deleteimage']);
    Route::resource('promo',\App\Http\Controllers\ProdukPromoController::class);
    Route::get('loadprodukasync/{id}',[\App\Http\Controllers\ProdukController::class,'loadasync']);
    Route::resource('eventdetail', App\Http\Controllers\EventDetailController::class);
    Route::get('pesanan', [\App\Http\Controllers\TransaksiController::class,'pesanan']);
    Route::get('pesanan/{id}', [\App\Http\Controllers\TransaksiController::class,'pesanandetail']);
    Route::post('kirimpesanan', [\App\Http\Controllers\TransaksiController::class,'kirimpesanan']);
  });

Route::group(['middleware' => 'auth'], function() {
    // cart
    Route::resource('cart', \App\Http\Controllers\CartController::class);
    Route::post('buynow',[\App\Http\Controllers\CartController::class,'buynow']);
    Route::patch('kosongkan/{id}', [\App\Http\Controllers\CartController::class,'kosongkan']);
    // cart detail
    Route::resource('cartdetail', \App\Http\Controllers\CartDetailController::class);
    Route::resource('alamatpengiriman', \App\Http\Controllers\AlamatPengirimanController::class);
    Route::get('checkout',[\App\Http\Controllers\CartController::class,'checkout']);
    Route::resource('transaksi',\App\Http\Controllers\TransaksiController::class);
    Route::get('transaksi_list', [\App\Http\Controllers\TransaksiController::class,'transaksi_list']);
    Route::get('transaksi_detail/{id}', [\App\Http\Controllers\TransaksiController::class,'transaksi_detail']);
    Route::resource('wishlist',\App\Http\Controllers\WishlistController::class);
    Route::resource('ulasan',\App\Http\Controllers\UlasanController::class);
    Route::get('beri_ulasan/{slug}', [\App\Http\Controllers\UlasanController::class, 'beri_ulasan']);
    Route::resource('reply', \App\Http\Controllers\ReplyController::class);
    Route::resource('profil',\App\Http\Controllers\UserController::class);
    Route::post('pesananditerima', [\App\Http\Controllers\TransaksiController::class,'pesananditerima']);
  });
  
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('payment-handler', [App\Http\Controllers\ApiController::class, 'payment_handler']);
