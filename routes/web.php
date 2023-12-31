<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\PengeluaranController;


use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SuplaiBahanController;
use App\Http\Controllers\UpdateLevelController;
use App\Http\Controllers\UpdatePasswordController;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('', LandingController::class);
Route::resource('categories', ProductCategoryController::class);

//---------route landingpage-------
Route::get('/about', function () {
    $toko = Toko::find(1); 
    return view('landingpage.about', compact('toko'));
});
Route::get('/portfolio', function () {
    $ar_kategori = Kategori::all();
    return view('landingpage.portfolio', compact('ar_kategori'));
});
Route::get('/services', function () {
    return view('landingpage.services');
});

Route::get('/contact', function () {
    $ar_kategori = Kategori::all();
    return view('landingpage.contact', compact('ar_kategori'));
});
Route::get('/ourbarang', function () {
    $ar_barang = DB::table('barang')
            ->join('kategori', 'kategori.id', '=', 'barang.kategori_id')
            ->select('barang.*', 'kategori.nama as kategori')
            ->orderBy('barang.id', 'desc')
            ->get();

    $ar_kategori = Kategori::all();
    return view('landingpage.ourbarang', compact('ar_kategori', 'ar_barang'));
});

Route::get('datauser', [UserController::class, 'index'])->middleware('auth');

Route::get('/beranda', [BarangController::class, 'dataBahan'])->middleware('auth');


//---------route landingpage kategori-------
Route::get('/coworking', function () {
    return view('landingpage.kategori-prod.coworking');
});
Route::get('/foto', function () {
    return view('landingpage.kategori-prod.foto');
});
Route::get('/largform', function () {
    return view('landingpage.kategori-prod.largform');
});
Route::get('/marketing', function () {
    return view('landingpage.kategori-prod.marketing');
});
Route::get('/packaging', function () {
    return view('landingpage.kategori-prod.packaging');
});
Route::get('/printkain', function () {
    return view('landingpage.kategori-prod.printkain');
});
Route::get('/printlembar', function () {
    return view('landingpage.kategori-prod.printlembar');
});
Route::get('/printterior', function () {
    return view('landingpage.kategori-prod.printterior');
});
Route::get('/promo', function () {
    return view('landingpage.kategori-prod.promo');
});
Route::get('/signage', function () {
    return view('landingpage.kategori-prod.signage');
});
Route::get('/stationary', function () {
    return view('landingpage.kategori-prod.stationary');
});
Route::get('/umkm', function () {
    return view('landingpage.kategori-prod.umkm');
});

//----------route admin------------

Route::get('/dashboard', [DashboardController::class, 'index']);


//login and logut
// Route::get('/login', function () {
//     return view('login', [
//         "title" => "Login"
//     ]);
// });
Route::get('/login', [loginController::class, 'login']);
Route::post('/login', [loginController::class, 'authenticate']);


// routes transaksi //


Route::get('/transaksi', function () {
    return view('formTransaksi', [
        "title" => "Transaksi"
    ]);
});

Route::get('transaksitable', [TransaksiController::class, 'show']);

Route::resource('kategori', KategoriController::class)->middleware('auth');
Route::resource('barang', BarangController::class)->middleware('auth');
Route::resource('pelanggan', PelangganController::class)->middleware('auth');
Route::resource('bahan', BahanController::class)->middleware('auth');
Route::resource('user', UserController::class)->middleware('auth');
Route::resource('transaksi', TransaksiController::class)->middleware('auth');
Route::resource('updatelevel', UpdateLevelController::class)->middleware('auth');
Route::resource('suplaibahan', SuplaiBahanController::class)->middleware('auth');
Route::resource('member', MemberController::class)->middleware('auth');
Route::resource('toko', TokoController::class)->middleware('auth');
Route::resource('pengeluaran', PengeluaranController::class)->middleware('auth');
Route::delete('/suplaibahan/deleteAll', [SuplaiBahanController::class, 'deleteAll'])->middleware('auth');
Route::get('/transaksi-pdf', [TransaksiController::class, 'transaksiPDF'])->name('transaksi.pdf')->middleware('auth');
Route::get('/pembukuan', [PengeluaranController::class, 'pembukuan'])->name('pembukuan.form')->middleware('auth');
Route::get('/pembukuan/cetak', [PengeluaranController::class, 'pembukuanCetak'])->name('pembukuan.cetak')->middleware('auth');
Route::get('/transaksi-pdf/cetak', [TransaksiController::class, 'transaksiPDFCetak'])->name('transaksi.pdf.cetak')->middleware('auth');
Route::get('/struk/{id}', [TransaksiController::class, 'struk'])->middleware('auth');
Route::get('/pelunasan', [TransaksiController::class, 'pelunasan']);
Route::get('/jatuhTempo', [TransaksiController::class, 'jatuhTempo']);
Route::get('/transaksi/{id}/pelunasan', [TransaksiController::class, 'editLunas'])->name('transaksi.editLunas')->middleware('auth');
Route::put('/transaksi/{id}/pelunasan', [TransaksiController::class, 'lunas'])->name('transaksi.lunas')->middleware('auth');
Route::get('/suplaibahan-pdf', [SuplaiBahanController::class, 'suplaibahanPDF'])->middleware('auth');
Route::get('/transaksi-excel', [TransaksiController::class, 'transaksiExcel'])->middleware('auth');
Route::get('/account/settings', [AccountSettingController::class, 'index'])->name('user.setting')->middleware('auth');
Route::put('/account/settings', [AccountSettingController::class, 'update'])->name('user.setting.update')->middleware('auth');
Route::get('/account/settings/updatePassword', [UpdatePasswordController::class, 'index'])->name('user.settingpassword')->middleware('auth');
Route::put('/account/settings/updatePassword', [UpdatePasswordController::class, 'update'])->name('user.settingpassword.update')->middleware('auth');


Auth::routes();

Route::get('/home', [DashboardController::class, 'index'])->middleware('auth');
