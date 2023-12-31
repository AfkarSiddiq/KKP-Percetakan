<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Transaksi;

class TokoController extends Controller
{
    public function index()
    {   
        $rs = Toko::find(1);
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('toko.index', compact('rs', 'jatuhTempoCount'), ['title' => "Pengaturan Profil Toko"]);
    }

    public function edit(string $id){

        $row = Toko::findOrFail($id);
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('toko.form_edit', compact('row', 'jatuhTempoCount'), ['title' => "Edit Profil Toko"]);
    }

    public function update(Request $request, string $id){
        $this->validate($request, [
            'nama' => 'required',
            'kode_nota' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'no_rekening' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:10000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:10000',
        ]);

        $row = Toko::findOrFail($id);
        $namaFotoLama = $row->foto;
        $namaLogoLama = $row->logo;
        $logoBaru = $request->file('logo');
        $fotoBaru = $request->file('foto');

        if(!empty($logoBaru)){
            //get the ext of the file
            $ext = $logoBaru->getClientOriginalExtension();
            //set the name is logo.extension
            $namaLogoBaru = "logo.".$ext;
            //move the file to folder assets/img
            $logoBaru->move(public_path().'/assets/img/', $namaLogoBaru); 
            //delete the old file
        } 
        if (!empty($fotoBaru) ){
            //get the ext of the file
            $ext2 = $fotoBaru->getClientOriginalExtension();
            //set the name is logo.extension
            $namaFotoBaru = "about.".$ext2;
            $fotoBaru->move(public_path().'/assets/img/', $namaFotoBaru);
            //delete the old file
        }
        if(empty($logoBaru)){
            $namaLogoBaru = $namaLogoLama;
        }
        if(empty($fotoBaru)){
            $namaFotoBaru = $namaFotoLama;
        }

        
        $data = [
            'nama' => $request->nama,
            'kode_nota' => $request->kode_nota,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'no_rekening' => $request->no_rekening,
            'logo' => $namaLogoBaru,
            'foto' => $namaFotoBaru
        ];

        if($row->update($data)){
            return redirect()->route('toko.index')->with('success', 'Data berhasil diubah');
        }
    }
}
