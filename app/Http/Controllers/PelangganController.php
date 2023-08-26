<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan; // Import the correct model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;


class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_pelanggan = Pelanggan::orderBy('id', 'desc')->get();
        //count transaksi by id pelanggan
        foreach ($ar_pelanggan as $p) {
            $p->jumlah_pesanan = DB::table('transaksi')
                ->where('pelanggan_id', '=', $p->id)
                ->count();
        }

        return view('pelanggan.index', compact('ar_pelanggan'), ['title' => 'Data Pelanggan']);
    }

    /* public function dataBahan()
    {
        $ar_bahan = Pelanggan::all();

        return view('landingpage.hero', compact('ar_bahan'), ['title' => 'Data Pelanggan']);
    }*/

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.form', ['title' => 'Input Pelanggan Baru']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:45',
            'alamat' => 'required',
            'no_hp' => 'required|max:15',
            'status_member' => 'required',
        ]);


        
            DB::table('pelanggan')->insert([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'status_member' => $request->status_member,
                'jumlah_pesanan' => '0',
            ]);

            return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan Baru Berhasil Disimpan');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = Pelanggan::find($id);
        //count transaksi by id pelanggan
        $rs->jumlah_pesanan = DB::table('transaksi')
            ->where('pelanggan_id', '=', $id)
            ->count();

        return view('pelanggan.detail', compact('rs'), ['title' => 'Detail Pelanggan']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = Pelanggan::find($id);

        return view('pelanggan.form_edit', compact('row'), ['title' => 'Edit Pelanggan']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'nama' => 'required|max:45',
                'alamat' => 'required',
                'no_hp' => 'required|max:15',
                'status_member' => 'required|boolean',
            ],

            [
                // Custom error messages
            ]
        );

        DB::table('pelanggan')->where('id', $id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'status_member' => $request->status_member,
            'jumlah_pesanan' => 0,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($id);

            if ($pelanggan->foto && Storage::exists('admin/assets/img/' . $pelanggan->foto)) {
                Storage::delete('admin/assets/img/' . $pelanggan->foto);
            }

            $pelanggan->delete();

            return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan Berhasil Dihapus');
        } catch (QueryException $e) {
            $errorCode = $e->getCode();
            if ($errorCode == 23000) {
                return redirect()->route('pelanggan.index')
                    ->with('error', 'Data pelanggan Gagal Dihapus, Karena Data Masih Digunakan');
            } else {
                return redirect()->route('pelanggan.index')
                    ->with('error', 'Data pelanggan Gagal Dihapus');
            }
        }
    }

    public function batal()
    {
        $ar_pelanggan = DB::table('pelanggan')->orderBy('pelanggan.id', 'desc')->get();

        return view('pelanggan.index', compact('ar_pelanggan'), ['title' => 'Data Pelanggan']);
    }
}
