<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Barang; //panggil model
use App\Models\Bahan;
use App\Models\Pelanggan;
//toko model
use App\Models\Toko;
use Illuminate\Support\Facades\DB; // jika pakai query builder
use Illuminate\Database\Eloquent\Model; //jika pakai eloquent
use PDF;
use App\Exports\transaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;


class TransaksiController extends Controller
{


    public function index()
    {
        $ar_transaksi = Transaksi::all(); //eloquent
        // sort by newest date
        $ar_transaksi = $ar_transaksi->sortByDesc('created_at');
        // set status to 2 if jatuh tempo is less than today
        foreach($ar_transaksi as $transaksi){
            if($transaksi->total_bayar == $transaksi->total_harga){
                $transaksi->status = 1;
                $transaksi->save();
            }else{
                if($transaksi->jatuh_tempo <= date('Y-m-d')){
                    $transaksi->status = 2;
                    $transaksi->save();
                }else{
                    $transaksi->status = 0;
                    $transaksi->save();
                }
            }
        }
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('transaksi.index', compact('ar_transaksi', 'jatuhTempoCount'), ['title' => 'Data Transaksi']);
    }

    public function pelunasan()
    {
        $ar_transaksi = Transaksi::where('status', 0)->orWhere('status', 2)->get(); //eloquent
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('transaksi.pelunasan', compact('ar_transaksi', 'jatuhTempoCount'), ['title' => 'Transaksi yang belum lunas']);
    }

    public function jatuhTempo()
    {
        // transaksi where status 0 dan tanggal jatuh tempo lebih dari = hari ini
        $ar_transaksi = Transaksi::where('status', 2)->get(); //eloquent
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('transaksi.jatuh_tempo', compact('ar_transaksi', 'jatuhTempoCount'), ['title' => 'Transaksi yang jatuh tempo']);
    }

    public function struk($id)
    {   
        $ar_transaksi = Transaksi::find($id); //eloquent
        $toko = Toko::find(1);
        if($ar_transaksi->keterangan == null){
            $ar_transaksi->keterangan = "-";
        }
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('transaksi.one_transaksi_pdf', compact('ar_transaksi', 'toko', 'jatuhTempoCount'), ['title' => 'Data Transaksi yang belum lunas']);
    }
    
    public function dataTerpilih()
    {
        $ar_transaksi = Transaksi::all(); //eloquent
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('landingpage.hero', compact('ar_terpilih', 'jatuhTempoCount'));
    }
    public function create()
    {
        //ambil master untuk dilooping di select option
        $ar_barang = DB::table('barang')
            ->orderBy('barang.id', 'desc')
            ->get();
        $ar_pelanggan = DB::table('pelanggan')
            ->orderBy('pelanggan.id', 'desc')
            ->get();

        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        //arahkan ke form input data
        return view('transaksi.form', compact('ar_barang', 'ar_pelanggan', 'jatuhTempoCount'), ['title' => 'Input Transaksi Baru']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //proses input barang dari form
        $request->validate([
            'tgl' => 'required|date',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
            'keterangan' => '',
            'total_harga' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'sisa' => 'required|numeric',
            'pembayaran' => 'required',
            'jatuh_tempo' => 'required|date',
        ]);

        $request->all();

        $selectedBarang = $request->input('barang');
        $dataBarang = explode(' | ', $selectedBarang);

        $idBarang = $dataBarang[0];
        $idBahan = $dataBarang[5];

        $selectedPelanggan = $request->input('nama');
        $dataPelanggan = explode(' | ', $selectedPelanggan);

        $idPelanggan = $dataPelanggan[0];

        // pembulatan keatas panjang dan lebar
        $panjang = ceil($request->panjang * 2) / 2;
        $lebar = ceil($request->lebar * 2) / 2;
        
        $barang = Barang::find($idBarang);

        //update jumlah stok barang pada bahan
        $bahan = DB::table('bahan')->where('id', $idBahan)->first();
        $jumlahBahan = $bahan->jumlah;
        if(strtolower($bahan->satuan) == strtolower($barang->satuan)){
            $jumlahBahan = $jumlahBahan - ($panjang * $lebar * $request->jumlah);
        }
        else if(strtolower($bahan->satuan) == 'lembar' && strtolower($barang->satuan) == 'pcs'){
            $jumlahBahan = $jumlahBahan - ($panjang * $lebar * $request->jumlah) * 0.2;
        }

        //check apakah stok bahan cukup
        if ($jumlahBahan < 0) {
            return back()->with('errors', 'Stok bahan tidak cukup');
        }
        
        $sisa = $request->sisa;
        $status = 0;
        if($sisa == 0){
            $status = 1;
        }else{
            $status = 0;
        }
        $pembayaran = $request->pembayaran;
        $total_bayar = $request->total_bayar - $request->kembalian;
        $transaksi = new Transaksi([
            'pelanggan_id' => $idPelanggan,
            'barang_id' => $idBarang,
            'tgl' => $request->tgl,
            'jumlah' => $request->jumlah,
            'panjang' => $panjang,
            'lebar' => $lebar,
            'harga' => $request->harga,
            'luas' => $panjang * $lebar,
            'total_harga' => $request->total_harga,
            'total_bayar' => $request->total_bayar,
            'sisa' => $sisa,
            'status' => $status,
            'keterangan' => $request->keterangan,
            'pembayaran' => $pembayaran,
            'jatuh_tempo' => $request->jatuh_tempo,
        ]);
        // DB::table('barang')->where('id', $idBarang)->update(
        //     [
        //         'stok' => DB::raw('stok + ' . $request->jumlah),
        //     ]
        // );
        if ($transaksi->save()) {
            // Update bahan and other relevant data if needed
            Bahan::where('id', $idBahan)->update(
                [
                    'jumlah' => $jumlahBahan,
                ]
            );
            return redirect('transaksi')->with('pesan', 'Barang Masuk berhasil disimpan');
        } else {
            return back()->with('errror', 'Barang Masuk gagal disimpan');
        }
    }
    public function edit(string $id)
    {
        
        //tampilkan data lama di form
        $row = Transaksi::find($id);

        $barang = Barang::find($row->barang_id);
        $pelanggan = Pelanggan::find($row->pelanggan_id);

        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('transaksi.form_edit', compact('row', 'barang', 'pelanggan', 'jatuhTempoCount'), ['title' => 'Edit Data Transaksi']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //proses input barang dari form
        $request->validate([
            'tgl' => 'required|date',
            'jumlah' => 'required|integer',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'keterangan' => '',
            'total_harga' => '',
            'total_bayar' => 'required|numeric',
            'sisa' => 'required|numeric',
            'pembayaran' => 'required',
            'jatuh_tempo' => 'required|date',
        ]);

        //lakukan update data dari request form edit
        $transaksi = Transaksi::find($id);

        $selectedBarang = $request->input('barang');
        $dataBarang = explode(' | ', $selectedBarang);

        $idBarang = $dataBarang[0]; 
        $barang = DB::table('barang')->where('id', $idBarang)->first();
        $idBahan = $barang->bahan_id;
        $selectedPelanggan = $request->input('nama');
        $dataPelanggan = explode(' | ', $selectedPelanggan);

        $idPelanggan = $dataPelanggan[0];

        $barang = Barang::find($idBarang);

        // pembulatan keatas panjang dan lebar
        $panjang = ceil($request->panjang * 2) / 2;
        $lebar = ceil($request->lebar * 2) / 2;   

        //update jumlah stok barang pada bahan
        $bahan = DB::table('bahan')->where('id', $idBahan)->first();
        $jumlahBahanLama = $bahan->jumlah;
        
        if(strtolower($bahan->satuan) == strtolower($barang->satuan)){
            $penguranganLama = $transaksi->luas * $transaksi->jumlah;
            $penguranganBaru = $panjang * $lebar * $request->jumlah;
            $jumlahBahanBaru = $jumlahBahanLama + $penguranganLama - $penguranganBaru;
        }
        else if(strtolower($bahan->satuan) == 'lembar' && strtolower($barang->satuan) == 'pcs'){
            $penguranganLama = $transaksi->luas * $transaksi->jumlah * 0.2;
            $penguranganBaru = $panjang * $lebar * $request->jumlah * 0.2;
            $jumlahBahanBaru = $jumlahBahanLama + $penguranganLama - $penguranganBaru;
        }
        
        
        //check apakah stok bahan cukup
        if ($jumlahBahanBaru < 0) {
            return back()->with('errors', 'Stok bahan tidak cukup');
        }
        $total_bayar = $request->total_bayar - $request->kembalian;
        // Update the attributes
        $transaksi->pelanggan_id = $idPelanggan;
        $transaksi->barang_id = $idBarang;
        $transaksi->tgl = $request->tgl;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->harga = $request->harga;
        $transaksi->panjang = $panjang;
        $transaksi->lebar = $lebar;
        $transaksi->luas = $panjang * $lebar;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->keterangan = $request->keterangan;
        $transaksi->total_bayar = $total_bayar;
        $transaksi->pembayaran = $request->pembayaran;
        $transaksi->jatuh_tempo = $request->jatuh_tempo;

        $sisa = $request->sisa;
        $status = $transaksi->status;
        if($sisa == 0){
            $status = 1;
        }else{
            $status = 0;
        }

        $transaksi->sisa = $sisa;
        $transaksi->status = $status;

        if ($transaksi->save()) {
            // Update bahan and other relevant data if needed
            Bahan::where('id', $idBahan)->update([
                'jumlah' => $jumlahBahanBaru,
            ]);
            return redirect()->route('transaksi.show', $id)->with('success', 'Data Transaksi Berhasil Diubah');
        } else {
            return back()->with('errors', 'Data Transaksi Gagal Diubah');
        }
        
    }
    
    public function editLunas(string $id)
    {
        //ambil master untuk dilooping di select option
        $row = Transaksi::find($id);
        $ar_barang = Barang::find($row->barang_id);
        $pelanggan = Pelanggan::find($row->pelanggan_id);

        $jatuhTempoCount = Transaksi::where('status', 2)->count();

        return view('transaksi.pelunasan_edit', compact('row', 'ar_barang', 'pelanggan', 'jatuhTempoCount'), ['title' => 'Pelunasan Transaksi']);
    }

    public function lunas(Request $request, string $id)
    {
        $transaksi = Transaksi::find($id);
        $sisa = $request->sisa;
        $status = $transaksi->status;
        if($sisa == 0){
            $status = 1;
        }else{
            $status = 0;
        }
        $transaksi->status = $status;
        $transaksi->sisa = $sisa;
        $total_bayar = $request->total_bayar - $request->kembalian;
        $transaksi->total_bayar += $total_bayar;

        if($transaksi->save()){
            return redirect()->route('transaksi.show', $id)->with('success', 'Data Transaksi Berhasil Diubah');
        }
    }
    //     return redirect()->back()
    //         ->with('error', 'Data Transaksi tidak ditemukan');
    // }
    public function show($id)
    {

        return redirect('/transaksi')->with('error', 'Invalid request. Cannot access specific resource.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //hapus data di database
        $transaksi = Transaksi::where('id', $id)->first();
        $barang = Barang::where('id', $transaksi->barang_id)->first();
        $bahan = Bahan::where('id', $barang->bahan_id)->first();
        $jumlahBahan = $bahan->jumlah;

        $jumlahBahanDikembalikan = 0;
        
        if(strtolower($bahan->satuan) == strtolower($barang->satuan)){
            $jumlahBahanDikembalikan = $transaksi->luas * $transaksi->jumlah;
        }
        else if(strtolower($bahan->satuan) == 'lembar' && strtolower($barang->satuan) == 'pcs'){
            $jumlahBahanDikembalikan = $transaksi->luas * $transaksi->jumlah * 0.2;
        }
        $delete = $transaksi->delete();
        if($delete){
            $bahan->jumlah = $jumlahBahan + $jumlahBahanDikembalikan;
            $bahan->save();
            return redirect()->route('transaksi.index')
                ->with('success', 'Data Transaksi Berhasil Dihapus');
        }
    }

    public function batal()
    {
        $ar_transaksi = DB::table('transaksi')
            ->join('barang', 'barang.id', '=', 'transaksi.barang_id')
            ->select('transaksi.*', 'barang.kode as barang')
            ->join('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->select('transaksi.*', 'barang.nama_barang as barang', 'barang.kode as kode', 'pelanggan.nama as pelanggan')
            ->orderBy('transaksi.id', 'desc')
            ->get();
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('transaksi.index', compact('ar_transaksi', 'jatuhTempoCount'), ['title' => 'Data Transaksi']);
    }

    public function transaksiPDFCetak(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama' => 'nullable',
            'status' => 'nullable|string',
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_mulai',
        ]);
    
        $selectedPelanggan = $request->input('nama');
        $dataPelanggan = explode('|', $selectedPelanggan);
        $idPelanggan = $dataPelanggan[0];

        $status = $request->input('status');
        $tgl_mulai = $request->input('tgl_mulai');
        $tgl_akhir = $request->input('tgl_akhir');
    
        $query = Transaksi::query();

        $toko = Toko::find(1);

        if ($idPelanggan) {
            $query->where('pelanggan_id', $idPelanggan);
            $pelanggan = Pelanggan::find($idPelanggan);
        }
        $lunas_box = "";
        if ($status) {
            // $query->where('status', $status == 'Lunas' ? 1 : 0);
            // where status Lunas = 1, Belum Lunas = 0 else 2
            if($status == 'Lunas'){
                $query->where('status', 1);
            }else if($status == 'Belum Lunas'){
                $query->where('status', 0)->orWhere('status', 2);
            }else if($status == 'Jatuh Tempo'){
                $query->where('status', 2);
            }
        }
        
        $ar_transaksi = $query->whereBetween('tgl', [$tgl_mulai, $tgl_akhir])->get();
        // sort by newest date
        $ar_transaksi = $ar_transaksi->sortByDesc('created_at');
        
        if($idPelanggan){
            $hutang = $ar_transaksi->sum('sisa');
            return view('transaksi.transaksi_pdf_2', compact('toko', 'ar_transaksi', 'tgl_mulai', 'tgl_akhir', 'hutang', 'pelanggan'), ['title' => 'Cetak Data Transaksi'])
            ->render();
        }
        return view('transaksi.transaksi_pdf', compact('toko', 'ar_transaksi', 'tgl_mulai', 'tgl_akhir'), ['title' => 'Cetak Data Transaksi'])
            ->render();
    }
    

    public function transaksiPDF(){
        $ar_pelanggan = Pelanggan::all();
        $jatuhTempoCount = Transaksi::where('status', 2)->count();

        return view('transaksi.pdf_form', compact('ar_pelanggan', 'jatuhTempoCount'), ['title' => 'Cetak Data Transaksi']);
    }

    public function transaksiExcel()
    {
        return Excel::download(new transaksiExport, 'data_transaksi_' . date('d-m-Y') . '.xlsx');
    }
}
