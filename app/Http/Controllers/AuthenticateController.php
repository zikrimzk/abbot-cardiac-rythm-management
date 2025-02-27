<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthenticateController extends Controller
{
    public function staffLogin(Request $request) 
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('staff-dashboard-page');
        }
        return redirect()->route('login-page')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function staffLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();
        return redirect()->route('login-page')->with('success', 'You have successfully logged out.');
    }
}
