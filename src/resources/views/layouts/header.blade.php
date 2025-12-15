<header class="site-header">
    <div class="header-logo">
        <a href="{{ url('/attendance') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="勤怠管理アプリ ロゴ">
        </a>
    </div>
    <nav class="nav">
        <ul class="nav-list">
            @auth {{-- ログインしている場合 --}}
                <li><a href="{{ url('/attendance') }}">勤怠</a></li>

                {{-- 特定の画面でログアウトボタンを非表示にする --}}
                @unless(Route::is('register.create') || Route::is('login') || Route::is('verification.notice'))
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"class="header-logout">ログアウト</button>
                        </form>
                    </li>
                @endunless
            @endauth
        </ul>
    </nav>
</header>
