<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login()
    {
        return view("authentication.v_login");
    }

    public function post_login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()
                ->intended('/modules/dashboard')
                ->with('success', 'Anda Berhasil Login');
        }
    }

    public function logout()
    {
        try {

            DB::beginTransaction();

            Auth::logout();

            DB::commit();

            return redirect()->to("/login")->with("success", "Anda Berhasil Logout");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
