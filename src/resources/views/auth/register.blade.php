<form method="POST" action="{{ route('register.store') }}" novalidate>
    @csrf

    <!-- 名前 -->
    <div>
        <label for="name">名前</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

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

    <!-- パスワード確認 -->
    <div>
        <label for="password_confirmation">パスワード確認</label>
        <input type="password"name="password_confirmation" id="password_confirmation">
    </div>

    <!-- 登録ボタン -->
    <button type="submit">登録</button>
</form