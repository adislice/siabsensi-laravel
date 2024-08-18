<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        if (auth('web')->check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.login');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth('web')->attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login success');
        } else {
            return redirect()->back()->with('error', 'Login failed');
        }
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('login');
    }

}
