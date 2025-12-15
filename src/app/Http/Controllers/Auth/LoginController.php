<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ログイン画面を表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/attendance');
        }

        return back()->with('login_error', 'ログイン情報が登録されていません。');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout(); // ログアウト処理
        $request->session()->invalidate(); // セッションを無効化
        $request->session()->regenerateToken(); // セッショントークンを再生成

        return redirect()->route('login'); // ログイン画面にリダイレクト
    }
}