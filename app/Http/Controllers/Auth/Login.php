<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session for security
            $request->session()->regenerate();

            // Redirect to intended page or home
            $url = '';
            
            $user = Auth::user();
            if ($user->hasRole('admin') || $user->hasRole('superAdmin')) {
                $url = '/admin/dashboard';
            } elseif ($user->hasRole('dosen')) {
                $url = '/dosen/dashboard';
            }

            return redirect()->intended($url)
                ->with('success', 'Welcome back, '.ucfirst($user->getRoleNames()->first()).'!');
        }

        // If login fails, redirect back with error
        return back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->onlyInput('email');
    }
}
