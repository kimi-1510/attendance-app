<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Responses\CustomLoginResponse;
use App\Http\Responses\CustomLogoutResponse;


class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ログイン画面
        Fortify::loginView(fn() => view('auth.login'));

        // 会員登録画面
        Fortify::registerView(fn() => view('auth.register'));

        // メール認証画面
        Fortify::verifyEmailView(fn() => view('auth.verify-email'));

        // ログイン認証処理のカスタマイズ
        // メールアドレスとパスワードが一致したらログイン成功
        Fortify::authenticateUsing(function(Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                // ロールに応じてリダイレクト先をセッションに保存
                if ($user->role === 'admin') {
                    session(['redirect_to' => '/admin/attendances']); // 管理者
                } else {
                    session(['redirect_to' => '/attendance']); // 一般ユーザー
                }
                return $user; // ログイン成功時にユーザーを返す
            }
            return null; // ログイン失敗時にnullを返す
        });
    }

    public function register()
    {
        // ログイン成功時のリダイレクトをカスタマイズする
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
        // ログアウト成功時のリダイレクトをカスタマイズする
        $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
    }
}