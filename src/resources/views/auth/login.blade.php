<!DOCTYPE html>
<html>
<head>
    <title>ログイン</title>
</head>
<body>

    <h1>ログイン</h1>
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <!-- メールアドレス -->
        <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- パスワード -->
        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password">
            @error('password')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- ログインボタン -->
        <button type="submit">ログインする</button>
        @if(session('login_error'))   
            <div style="color: red;">{{ session('login_error') }}</div>
        @endif
    </form>
    <a href="{{ route('register.store') }}">会員登録はこちら</a>
</body>
</html>