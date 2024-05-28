<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('pages.auth.login');
    }

    public function todoLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required',
            'password.string' => 'Password is not valid'
        ]);

        $remember = $request->has('remember') ? true : false;

        if(Auth::attempt($request->only('email', 'password'), $remember)) {
            Alert::success('', 'Login Success');
            return redirect()->route('dashboard');
        }

        Alert::warning("", "Login Failed");
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        Alert::success('', 'Logout Success');
        return redirect()->route('login');
    }
}
