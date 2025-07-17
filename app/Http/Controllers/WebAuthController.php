<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    //at first user should login to see his posts on the dashboard and edit - delete - create post 


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {
            if (!Auth::user()->is_verified) {
                return back()->withErrors(['email' => 'Account not verified.']);
            }
            $request->session()->regenerate();
          return redirect('/home');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

}
