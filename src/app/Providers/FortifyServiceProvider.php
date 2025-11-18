<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Illuminate\Http\Request;


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
    }
}