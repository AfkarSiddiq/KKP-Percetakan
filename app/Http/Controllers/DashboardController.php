<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang; //panggil model
use App\Models\Bahan; //panggil model
use App\Models\Kategori; //panggil model
use App\Models\Pelanggan; //panggil model
use App\Models\Transaksi; //panggil model
use Illuminate\Support\Facades\DB; // jika pakai query builder
use Illuminate\Database\Eloquent\Model; //jika pakai eloquent

class DashboardController extends Controller
{
        public function index()
        {
                //query untuk grafik bahan paling banyak habis bulan ini dengan hubungan denagn table transaksi, jumlah totalnya adalah luas * jumlah
                $ar_stok = DB::table('barang')
                        ->selectRaw('sum(transaksi.jumlah * transaksi.luas) as jumlah, bahan.nama_bahan as nama_bahan')
                        ->where('bahan.satuan', 'LIKE' , '%meter%')
                        ->whereRaw('transaksi.created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->join('transaksi', 'barang_id', '=', 'barang.id')
                        ->join('bahan', 'barang.bahan_id', '=', 'bahan.id')
                        ->groupBy('nama_bahan')
                        ->orderBy('jumlah', 'desc')
                        ->get();

                $ar_stok_not_meter = DB::table('barang')
                        ->selectRaw('sum(transaksi.jumlah * transaksi.luas) as jumlah, bahan.nama_bahan as nama_bahan')
                        ->where('bahan.satuan', 'NOT LIKE' , '%meter%')
                        ->whereRaw('transaksi.created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->join('transaksi', 'barang_id', '=', 'barang.id')
                        ->join('bahan', 'barang.bahan_id', '=', 'bahan.id')
                        ->groupBy('nama_bahan')
                        ->orderBy('jumlah', 'desc')
                        ->get();


                //query untuk menampilkan jumlah barang per kategori (pie chart) menggunakan model
                // $ar_jumlah = DB::table('barang')
                //         ->join('kategori', 'kategori.id', '=', 'barang.kategori_id')
                //         ->selectRaw('kategori.nama, count(barang.kategori_id) as jumlah')
                //         ->groupBy('kategori.nama')
                //         ->get();
                $ar_jumlah = DB::table('barang')
                        ->selectRaw('sum(transaksi.jumlah * transaksi.luas) as jumlah, barang.nama_barang as nama_barang')
                        ->whereRaw('transaksi.created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->join('transaksi', 'barang_id', '=', 'barang.id')
                        ->join('bahan', 'barang.bahan_id', '=', 'bahan.id')
                        ->groupBy('nama_barang')
                        ->orderBy('jumlah', 'desc')
                        ->get();

                //query untuk grafik uang belum masuk bulan ini
                $jml_pelanggan = DB::table('transaksi')
                        ->selectRaw('SUM(sisa) as jumlah')
                        ->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->get();

                //query untuk grafik transaksi bulan ini
                $jml_transaksi = DB::table('transaksi')
                        ->selectRaw('count(*) as jumlah')
                        ->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->get();

                $jml_pendapatan = DB::table('transaksi')
                        ->selectRaw('SUM(total_bayar) as jumlah')
                        ->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->get();

                $brg_laris = DB::table('barang')
                        ->select(array('nama_barang', DB::raw('COUNT(transaksi.barang_id) as jumlah')))
                        ->whereRaw('transaksi.created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->join('transaksi', 'barang_id', '=', 'barang.id' )
                        ->groupBy('nama_barang')
                        ->orderBy('jumlah', 'desc')
                        ->get();

                $jatuhTempoCount = Transaksi::where('status', 2)->count();
                return view('dashboard.index', compact('ar_stok_not_meter', 'jatuhTempoCount', 'ar_stok', 'ar_jumlah', 'jml_pelanggan', 'jml_transaksi','jml_pendapatan', 'brg_laris'), ['title' => 'Dashboard']);
        }
}