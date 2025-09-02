<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録 - FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="auth-container">
        <header class="header">
            <div class="brand">FashionablyLate</div>
            <a href="{{ route('login') }}" class="login-button">login</a>
        </header>

        <main class="main">
            <h1 class="page-title">Register</h1>

            <div class="form-panel">
                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">お名前</label>
                        <input type="text" id="name" name="name"
                            class="form-input @error('name') error-input @enderror" placeholder="例:山田 太郎"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input type="email" id="email" name="email"
                            class="form-input @error('email') error-input @enderror" placeholder="例: test@example.com"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">パスワード</label>
                        <input type="password" id="password" name="password"
                            class="form-input @error('password') error-input @enderror" placeholder="例:coachtech1106"
                            required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-button">登録</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
