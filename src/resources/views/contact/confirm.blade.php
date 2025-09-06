{{-- 
    お問い合わせ内容確認画面（confirm.blade.php）
    
    このファイルの役割：
    - ユーザーが入力したお問い合わせ内容を確認画面で表示
    - 修正が必要な場合は入力画面に戻る機能
    - 確認後にお問い合わせを送信する機能
    - 入力データの整形表示（性別の数値→テキスト変換など）
    
    主な機能：
    - 入力されたすべての項目の表示
    - 性別の数値を日本語に変換して表示
    - 電話番号の整形表示
    - 修正ボタン（入力画面に戻る）
    - 送信ボタン（最終送信処理）
    
    技術的な特徴：
    - セッションから取得した入力データ ($contactData) を表示
    - 静的メソッド呼び出し (ContactController::getGenderText())
    - 隠しフィールドでのデータ保持 (hidden input)
    - CSRF保護
--}}
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm - FashionablyLate</title>
    {{-- 基本スタイル（contact.css）と確認画面専用スタイル（confirm.css）を読み込み --}}
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>

<body>
    <div>
        <header class="header">
            <h1 class="brand">FashionablyLate</h1>
        </header>

        <main class="confirm-main">
            <h2 class="confirm-title">Confirm</h2>

            <div class="confirmation-panel">
                <div class="confirmation-row">
                    <div class="confirmation-label">お名前</div>
                    <div class="confirmation-value">
                        {{ $contactData['last_name'] }} {{ $contactData['first_name'] }}
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

                <form action="{{ route('contact.edit') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $contactData['category_id'] }}">
                    <input type="hidden" name="first_name" value="{{ $contactData['first_name'] }}">
                    <input type="hidden" name="last_name" value="{{ $contactData['last_name'] }}">
                    <input type="hidden" name="gender" value="{{ $contactData['gender'] }}">
                    <input type="hidden" name="email" value="{{ $contactData['email'] }}">
                    <input type="hidden" name="phone1" value="{{ explode('-', $contactData['tell'])[0] ?? '' }}">
                    <input type="hidden" name="phone2" value="{{ explode('-', $contactData['tell'])[1] ?? '' }}">
                    <input type="hidden" name="phone3" value="{{ explode('-', $contactData['tell'])[2] ?? '' }}">
                    <input type="hidden" name="address" value="{{ $contactData['address'] }}">
                    <input type="hidden" name="building" value="{{ $contactData['building'] }}">
                    <input type="hidden" name="detail" value="{{ $contactData['detail'] }}">
                    <button type="submit" class="edit-button">修正</button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
