<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('mahasiswa');

        Auth::login($user);

        if($user->hasRole('admin')){
            return redirect('/admin/dashboard')->with('success', 'Welcome Admin!');
        }elseif($user->hasRole('dosen')){
            return redirect('/dosen/dashboard')->with('success', 'Welcome Dosen!');
        }else{
            return redirect('/mahasiswa/dashboard')->with('success', 'Welcome Mahasiswa');
        }
    }
}
