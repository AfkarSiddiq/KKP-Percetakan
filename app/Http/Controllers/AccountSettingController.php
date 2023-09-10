<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;
use App\Models\Transaksi;


class AccountSettingController extends Controller
{
    public function index()
    {
        $ar_user = Auth::user();
        $jatuhTempoCount = Transaksi::where('status', 2)->count();
        return view('user.setting', compact('ar_user', 'jatuhTempoCount'), ['title' => 'Setting']);
    }

    public function update(Request $request)
    {

        $user = Auth::user();

        // Validate the form data


        $validatedData = $request->validate([
            // Add your validation rules here
            'name' => ['string', 'max:255'],
            'email' => [],
            'alamat' => ['string', 'max:255'],
            'no_hp' => ['numeric'],
            'current_password' => ['required', 'string', 'min:8'],
        ], [
            'name.string' => 'Name must be string',
            'name.max' => 'Name max 255 character',
            'alamat.string' => 'Alamat must be string',
            'alamat.max' => 'Alamat max 255 character',
            'no_hp.numeric' => 'No Hp must be numeric',
            'no_hp.min' => 'No Hp min 11 character',
            'current_password.required' => 'Current Password is required',
            'current_password.string' => 'Current Password must be string',
            'current_password.min' => 'Current Password min 8 character',

        ]);


        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        // $user->level = $validatedData['level'];
        // $user->password = Hash::make($validatedData['password']);
        $user->alamat = $validatedData['alamat'];
        $user->no_hp = $validatedData['no_hp'];
        $user->save();

        if ($user) {
            // Display success message to the admin
            session()->flash('success', 'Account Update successfully.');
        } else {
            session()->flash('error', 'Failed to Update the account.');
        }
        return redirect('datauser');
    }
}
