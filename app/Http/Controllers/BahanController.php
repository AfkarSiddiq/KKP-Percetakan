<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//model
use App\Models\Bahan;
use App\Models\Barang;

class BahanController extends Controller
{
    public function index()
    {   
        //ambil data dari table bahan dan relasikan dengan table barang
        $ar_bahan = Bahan::with('barang')->get();

        $title = 'Data Bahan';

        return view('bahan.index', compact('ar_bahan'), ['title'=>$title]);
    }

    public function show($id)
    {
        $rs = Barang::where('bahan_id', $id)->get();
        $title = Bahan::findOrFail($id)->nama_bahan;

        return view('bahan.detail', compact('rs'), ['title'=>$title]);
    }

    public function create()
    {
        $ar_barang = Barang::all();
        return view('bahan.form', compact('ar_barang'), ['title'=>'Tambah Data Bahan']);
    }

    public function store(Request $request)
    {
        $rule = [
            'nama_bahan'=>'required|unique:bahan,nama_bahan',
            'jumlah'=>'required|numeric',
            'satuan'=>'required',
        ];
        $this->validate($request, $rule);

        $input = $request->all();

        Bahan::create($input);

        return redirect('/bahan')->with('status', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $row = Bahan::findOrFail($id);

        return view('bahan.form_edit', compact('row'), ['title'=>'Edit Data Bahan']);
    }

    public function update(Request $request, $id)
    {
        $rule = [
            'nama_bahan'=>'required|unique:bahan,nama_bahan,'.$id,
            'jumlah'=>'required|numeric',
            'satuan'=>'required',
        ];
        $this->validate($request, $rule);

        $input = $request->all();

        $row = Bahan::findOrFail($id);
        $row->update($input);

        return redirect('/bahan')->with('status', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $row = Bahan::findOrFail($id);
        $row->delete();

        return redirect('/bahan')->with('status', 'Data berhasil dihapus');
    }
}
