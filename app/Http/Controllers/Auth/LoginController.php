<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect("/");
        }

        return view("auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            return redirect()->intended("/");
        }

        return redirect()
            ->back()
            ->withErrors([
                "email" => "The provided credentials do not match our records.",
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect("/login");
    }
}
