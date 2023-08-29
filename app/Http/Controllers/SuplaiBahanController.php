<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuplaiBahan;
use App\Models\Bahan;

class SuplaiBahanController extends Controller
{
    public function index(){
        $ar_suplai_bahan = SuplaiBahan::with('bahan')->get();

        return view('suplaiBahan.index', compact('ar_suplai_bahan'), ['title'=>'Data Suplai Bahan']);
    }

    public function create(){

        $ar_bahan = Bahan::all();

        return view('suplaiBahan.form', compact('ar_bahan'), ['title'=>'Tambah Data Suplai Bahan']);
    }

    public function store(Request $request){
        $validasi = $request->validate([
            'bahan'=>'required',
            'date'=>'required',
            'jumlah'=>'required|integer',
        ]);

        $selectedBahan = $request->input('bahan');
        $dataBahan = explode(' | ', $selectedBahan);

        $idBahan = $dataBahan[1];

        $input = $request->all();

        //make jumlah always positive
        if($input['jumlah'] < 0){
            $input['jumlah'] *= -1;
        }

        $ps_store = SuplaiBahan::create([
            'bahan_id'=>$idBahan,
            'tgl'=>$input['date'],
            'jumlah'=>$input['jumlah'],
            'keterangan'=>$input['keterangan']
        ]);

        if($ps_store){
            $ar_bahan = Bahan::find($idBahan);
            $ar_bahan->jumlah += $input['jumlah'];
            $ar_bahan->save();

            return redirect('suplaibahan')->with('success', 'Data berhasil ditambahkan');
        }

    }

    public function edit($id){
        $row = SuplaiBahan::find($id);
        $ar_bahan = Bahan::find($row->bahan_id);

        return view('suplaiBahan.form_edit', compact('row', 'ar_bahan'), ['title'=>'Edit Data Suplai Bahan']);
    }

    public function update(Request $request, $id){
        $validasi = $request->validate([
            'bahan'=>'required',
            'date'=>'required',
            'jumlah'=>'required|integer',
        ]);

        $idBahan = SuplaiBahan::find($id)->bahan_id;
        $penambahanLama = SuplaiBahan::find($id)->jumlah;
        $jumlahBahanLama = Bahan::find($idBahan)->jumlah;

        //make jumlah back to before store
        $jumlahBahanLama -= $penambahanLama;

        //get penambahanbaru and count it with jumlahBahanLama
        $penambahanBaru = $request->input('jumlah');
        $jumlahBahanBaru = $jumlahBahanLama + $penambahanBaru;

        $input = $request->all();

        //make jumlah always positive
        if($input['jumlah'] < 0){
            $input['jumlah'] *= -1;
        }

        $row = SuplaiBahan::find($id);
        $row->bahan_id = $idBahan;
        $row->tgl = $input['date'];
        $row->jumlah = $penambahanBaru;
        $row->keterangan = $input['keterangan'];

        $ps_update = $row->save();

        if($ps_update){
            $ar_bahan = Bahan::find($idBahan);
            $ar_bahan->jumlah = $jumlahBahanBaru;
            $ar_bahan->save();

            return redirect('suplaibahan')->with('success', 'Data berhasil diupdate');
        }
    }

    public function destroy($id){
        $row = SuplaiBahan::find($id);
        $idBahan = $row->bahan_id;
        $jumlahBahan = $row->jumlah;

        $ps_hapus = SuplaiBahan::destroy($id);

        if($ps_hapus){
            $ar_bahan = Bahan::find($idBahan);
            $ar_bahan->jumlah -= $jumlahBahan;
            $ar_bahan->save();

            return redirect('suplaibahan')->with('success', 'Data berhasil dihapus');
        }
    }

}
