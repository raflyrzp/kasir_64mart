<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Identitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function index()
    {
        $identitas = Identitas::findOrFail(1);
        return view('auth.index', compact('identitas'));
    }
    function login(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username harus diisi',
                'password.required' => 'Password harus diisi',
            ]
        );

        $infologin = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == "admin") {
                return redirect('admin');
            } else if (Auth::user()->role == "owner") {
                return redirect('owner');
            } else if (Auth::user()->role == "kasir") {
                return redirect('kasir');
            }
        } else {
            return redirect(route('login'))->withErrors('Username dan password yang dimasukkan tidak sesuai')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
