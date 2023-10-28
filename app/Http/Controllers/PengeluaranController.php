<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Transaksi;
use App\Models\Pemasukan;

class PengeluaranController extends Controller
{
    public function index()
    {   
        // pengeluaran order by newest
        $ar_pengeluaran = Pengeluaran::orderBy('tanggal', 'desc')->get();
        $jatuhTempoCount = Transaksi::where('status', 2)->count();

        return view('pengeluaran.index', compact('ar_pengeluaran', 'jatuhTempoCount'), ['title' => 'Pengeluaran']);
    }

    public function create()
    {   
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('pengeluaran.form', compact('jatuhTempoCount') , ['title' => 'Tambah Pengeluaran']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengeluaran' => 'required',
            'date' => 'required',
            'jumlah' => 'required',
            'pembayaran' => 'required',
            'keterangan' => 'required',
        ]);

        Pengeluaran::create([
            'user_id' => auth()->user()->id,
            'nama' => $request->nama_pengeluaran,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->date,
            'pembayaran' => $request->pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/pengeluaran')->with('status', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function edit(string $id){
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        $pengeluaran = Pengeluaran::find($id);
        return view('pengeluaran.form_edit', compact('pengeluaran', 'jatuhTempoCount'), ['title' => 'Edit Pengeluaran']);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama_pengeluaran' => 'required',
            'date' => 'required',
            'jumlah' => 'required',
            'pembayaran' => 'required',
            'keterangan' => 'required',
        ]);

        Pengeluaran::where('id', $id)
            ->update([
                'nama' => $request->nama_pengeluaran,
                'jumlah' => $request->jumlah,
                'tanggal' => $request->date,
                'pembayaran' => $request->pembayaran,
                'keterangan' => $request->keterangan,
            ]);

        return redirect('/pengeluaran')->with('status', 'Data pengeluaran berhasil diubah!');
    }

    public function destroy(string $id){
        Pengeluaran::destroy($id);
        return redirect('/pengeluaran')->with('status', 'Data pengeluaran berhasil dihapus!');
    }

    public function pembukuan(){
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('pembukuan.pdf_form', compact('jatuhTempoCount'), ['title' => 'Pembukuan']);
    }

    public function pembukuanCetak(request $request){
        // Validate the request
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $tgl_mulai = $request->input('tgl_mulai');
        $tgl_akhir = $request->input('tgl_akhir');

        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        $ar_pengeluaran = Pengeluaran::orderBy('tanggal', 'desc')->get();
        $ar_pemasukan = Pemasukan::orderBy('updated_at', 'desc')->get();

        // all jumlah pemasukan dan pengeluaran
        $omset = 0;
        foreach($ar_pemasukan as $pemasukan){
            $omset += $pemasukan->jumlah;
        }
        foreach($ar_pengeluaran as $pengeluaran){
            $omset -= $pengeluaran->jumlah;
        }

        // sum jumlah pemasukan dan pengeluaran yang pembayarannya cash
        $uang_laci = 0;
        foreach($ar_pemasukan as $pemasukan){
            if($pemasukan->pembayaran == 'cash'){
                $uang_laci += $pemasukan->jumlah;
            }
        }
        foreach($ar_pengeluaran as $pengeluaran){
            if($pengeluaran->pembayaran == 'cash'){
                $uang_laci -= $pengeluaran->jumlah;
            }
        }
        if($uang_laci < 0){
            $uang_laci = 0;
        }

        // sum jumlah pemasukan dan pengeluaran yang pembayarannya transfer
        $uang_transfer = 0;
        foreach($ar_pemasukan as $pemasukan){
            if($pemasukan->pembayaran == 'transfer'){
                $uang_transfer += $pemasukan->jumlah;
            }
        }
        foreach($ar_pengeluaran as $pengeluaran){
            if($pengeluaran->pembayaran == 'transfer'){
                $uang_transfer -= $pengeluaran->jumlah;
            }
        }
        if($uang_transfer < 0){
            $uang_transfer = 0;
        }
        
        $ar_pengeluaran = $ar_pengeluaran->whereBetween('tanggal', [$tgl_mulai, $tgl_akhir]);
        $ar_pemasukan = $ar_pemasukan->whereBetween('updated_at', [$tgl_mulai, $tgl_akhir]);

        // sum total jumlah pemasukan
        $total_pemasukan = 0;
        foreach($ar_pemasukan as $pemasukan){
            $total_pemasukan += $pemasukan->jumlah;
        }

        // sum total jumlah pengeluaran
        $total_pengeluaran = 0;
        foreach($ar_pengeluaran as $pengeluaran){
            $total_pengeluaran += $pengeluaran->jumlah;
        }

        // sum jumlah pemasukan dan pengeluaran yang sudah dihitung
        $total = $total_pemasukan - $total_pengeluaran;

        

        return view('pembukuan.pembukuan_pdf', compact('ar_pengeluaran', 'ar_pemasukan', 'jatuhTempoCount', 'tgl_mulai', 'tgl_akhir', 'total_pemasukan', 'total_pengeluaran', 'total', 'uang_laci', 'uang_transfer', 'omset'));
    }
}
