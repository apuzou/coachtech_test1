<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ詳細 - FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="admin-container">
        <header class="header">
            <div class="brand">FashionablyLate</div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-button">logout</button>
            </form>
        </header>

        <main class="main">
            <div class="detail-header">
                <h1 class="page-title">お問い合わせ詳細</h1>
                <a href="{{ route('admin.index') }}" class="back-button">← 一覧に戻る</a>
            </div>

            <div class="detail-panel">
                <div class="detail-row">
                    <div class="detail-label">お名前</div>
                    <div class="detail-value">{{ $contact->last_name }} {{ $contact->first_name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">性別</div>
                    <div class="detail-value">
                        {{ \App\Http\Controllers\AdminController::getGenderText($contact->gender) }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">メールアドレス</div>
                    <div class="detail-value">{{ $contact->email }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">電話番号</div>
                    <div class="detail-value">{{ $contact->tell }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">住所</div>
                    <div class="detail-value">{{ $contact->address }}</div>
                </div>

                @if (!empty($contact->building))
                    <div class="detail-row">
                        <div class="detail-label">建物名</div>
                        <div class="detail-value">{{ $contact->building }}</div>
                    </div>
                @endif

                <div class="detail-row">
                    <div class="detail-label">お問い合わせの種類</div>
                    <div class="detail-value">{{ $contact->category->content ?? '未選択' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">お問い合わせ内容</div>
                    <div class="detail-value">{{ $contact->detail }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">登録日時</div>
                    <div class="detail-value">{{ $contact->created_at->format('Y年m月d日 H:i') }}</div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
