<!DOCTYPE html>
<html>
    <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
    <p>メール認証を完了してください。</p>

    @if (session('status') == 'verification-link-sent')
        <p>新しい認証メールを送信しました。</p>
    @endif

    <!-- 認証はこちらからボタンを押すとメールアプリが開く -->
    <div style="margin-top: 20px;">
        <a href="http://localhost:8025" target="_blank">
            <button type="button">認証はこちらから</button>
        </a>
    </div>

    <!-- 認証メール再送リンク -->
    <div style="margin-top: 20px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:blue;text-decoration:underline;cursor:pointer;">
                認証メールを再送する
            </button>
        </form>
    </div>
</html>
