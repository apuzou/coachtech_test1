<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm - FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>

<body>
    <div class="confirm-container">
        <header class="header">
            <h1 class="brand">FashionablyLate</h1>
        </header>

        <main class="confirm-main">
            <h2 class="confirm-title">Confirm</h2>

            <div class="confirmation-panel">
                <div class="confirmation-row">
                    <div class="confirmation-label">お名前</div>
                    <div class="confirmation-value">{{ $contactData['last_name'] }} {{ $contactData['first_name'] }}
                    </div>
                </div>

                <div class="confirmation-row">
                    <div class="confirmation-label">性別</div>
                    <div class="confirmation-value">
                        {{ \App\Http\Controllers\ContactController::getGenderText($contactData['gender']) }}
                    </div>
                </div>

                <div class="confirmation-row">
                    <div class="confirmation-label">メールアドレス</div>
                    <div class="confirmation-value">{{ $contactData['email'] }}</div>
                </div>

                <div class="confirmation-row">
                    <div class="confirmation-label">電話番号</div>
                    <div class="confirmation-value">{{ $contactData['tell'] }}</div>
                </div>

                <div class="confirmation-row">
                    <div class="confirmation-label">住所</div>
                    <div class="confirmation-value">{{ $contactData['address'] }}</div>
                </div>

                @if (!empty($contactData['building']))
                    <div class="confirmation-row">
                        <div class="confirmation-label">建物名</div>
                        <div class="confirmation-value">{{ $contactData['building'] }}</div>
                    </div>
                @endif

                <div class="confirmation-row">
                    <div class="confirmation-label">お問い合わせの種類</div>
                    <div class="confirmation-value">{{ $category->content ?? '未選択' }}</div>
                </div>

                <div class="confirmation-row">
                    <div class="confirmation-label">お問い合わせ内容</div>
                    <div class="confirmation-value">{{ $contactData['detail'] }}</div>
                </div>
            </div>

            <div class="action-buttons">
                <form action="{{ route('contact.store') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $contactData['category_id'] }}">
                    <input type="hidden" name="first_name" value="{{ $contactData['first_name'] }}">
                    <input type="hidden" name="last_name" value="{{ $contactData['last_name'] }}">
                    <input type="hidden" name="gender" value="{{ $contactData['gender'] }}">
                    <input type="hidden" name="email" value="{{ $contactData['email'] }}">
                    <input type="hidden" name="tell" value="{{ $contactData['tell'] }}">
                    <input type="hidden" name="address" value="{{ $contactData['address'] }}">
                    <input type="hidden" name="building" value="{{ $contactData['building'] }}">
                    <input type="hidden" name="detail" value="{{ $contactData['detail'] }}">
                    <button type="submit" class="submit-button">送信</button>
                </form>
                <a href="{{ route('contact.index') }}" class="edit-button">修正</a>
            </div>
        </main>
    </div>
</body>

</html>
