<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request) 
    {
        // セッションからリダイレクト先を取得
        // なければ '/login' に行くように設定
        $redirectTo = session('redirect_to', '/login');

        // 使い終わったリダイレクト先を削除
        session()->forget('redirect_to');

        // intendedは「もともとアクセスしようとしていたURL」にリダイレクトするメソッド
        // なければ $redirectTo にリダイレクト
        return redirect()->intended($redirectTo);
    }
}