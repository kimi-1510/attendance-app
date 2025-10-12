<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract; 

class CustomLogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        // ログアウトしたユーザーを取得
        $user = $request->user();

        // ログアウトしたユーザーのroleに応じてリダイレクト先を設定
        // 管理者の場合は管理者ログイン画面にリダイレクト
        if ($user && $user->role === 'admin') {
            return redirect('admin/login'); 
        }

        // 一般ユーザーの場合は一般ログイン画面にリダイレクト
        return redirect('/login'); 
    }
}