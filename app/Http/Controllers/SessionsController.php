<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);

        if(Auth::attempt($attributes))
        {
            session()->regenerate();
            
            // Redirect based on role
            if(auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'You are logged in.');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'You are logged in.');
            }
        }

        return back()->withErrors(['email' => 'Email or password invalid.']);
    }
    
    public function destroy()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You\'ve been logged out.');
    }
}
