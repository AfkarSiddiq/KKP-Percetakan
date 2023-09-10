<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;

class MemberController extends Controller
{
    public function index()
    {
        $ar_member = DB::table('pelanggan')
            ->where('status_member', '1')
            // ->orderBy('member.id', 'desc')
            ->get();
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('member.index', compact('ar_member', 'jatuhTempoCount'), ['title' => 'Member']);
    }
}
