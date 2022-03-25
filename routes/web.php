<?php

use App\Http\Controllers\Admin\BanerController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\User\DikemasController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\MenungguController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\PengirimanController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SelesaiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
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
Route::match(['get', 'post'],'/', [AuthController::class, 'index']);
Route::match(['get', 'post'],'/logout', [AuthController::class, 'logout']);
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });

    Route::group(['prefix' => 'cabang'], function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\CabangController::class, 'index']);
        Route::post('/patch', [\App\Http\Controllers\CabangController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\CabangController::class, 'hapus']);
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\AdminController::class, 'index']);
        Route::post('/patch', [\App\Http\Controllers\AdminController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\AdminController::class, 'hapus']);
    });

    Route::group(['prefix' => 'jenis'], function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\JenisBarangController::class, 'index']);
        Route::post('/patch', [\App\Http\Controllers\JenisBarangController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\JenisBarangController::class, 'hapus']);
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\BarangController::class, 'index']);
        Route::post('/patch', [\App\Http\Controllers\BarangController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\BarangController::class, 'hapus']);
    });

    Route::group(['prefix' => 'stock'], function (){
        Route::get('/', [\App\Http\Controllers\StockController::class, 'index']);
        Route::get('/list', [\App\Http\Controllers\StockController::class, 'getList']);
    });

    Route::group(['prefix' => 'laporan-barang-masuk'], function (){
        Route::get('/', [\App\Http\Controllers\LaporanController::class, 'laporanBarangMasukPage']);
        Route::get('/list', [\App\Http\Controllers\LaporanController::class, 'laporanBarangMasukList']);
        Route::get('/print', [\App\Http\Controllers\LaporanController::class, 'laporanBarangMasukPrint']);
    });

    Route::group(['prefix' => 'laporan-barang-keluar'], function (){
        Route::get('/', [\App\Http\Controllers\LaporanController::class, 'laporanBarangKeluarPage']);
        Route::get('/list', [\App\Http\Controllers\LaporanController::class, 'laporanBarangKeluarList']);
        Route::get('/print', [\App\Http\Controllers\LaporanController::class, 'laporanBarangKeluarPrint']);
    });



});


//Route::get('/admin/stock', function () {
//    return view('admin.stok');
//});

Route::get('/admin/transaksi', function () {
    return view('admin.transaksi');
});

Route::get('/admin/laporantransaksi', function () {
    return view('admin.laporantransaksi');
});

Route::get('/admin/laporanpemasukan', function () {
    return view('admin.laporanpemasukan');
});

Route::prefix('laporantransaksi')->group(
    function () {
        Route::get('/', [\App\Http\Controllers\Admin\TransaksiController::class, 'laporanTransaksi']);
        Route::get('/cetak', [\App\Http\Controllers\Admin\TransaksiController::class, 'cetak']);

    }
);

Route::prefix('laporanpemasukan')->group(
    function () {
        Route::get('/', [\App\Http\Controllers\Admin\PemasukanController::class, 'index']);
        Route::get('/cetak', [\App\Http\Controllers\Admin\PemasukanController::class, 'cetak']);
    }
);

Route::get('/dmin/laporantransaksi/cetak', [LaporanController::class, 'cetakLaporanTransaksi']);
Route::get('/admin/laporanpemasukan/cetak', [LaporanController::class, 'cetakLaporanPemasukan']);

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-member', [AuthController::class, 'registerMember']);
