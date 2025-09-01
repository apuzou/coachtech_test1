<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
</head>

<body>
    <div class="contact-container">
        <header class="header">
            <h1 class="brand">FashionablyLate</h1>
        </header>

        <main class="contact-main">
            <h2 class="contact-title">Contact</h2>

            <form class="contact-form" action="{{ route('contact.confirm') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">
                        お名前 (Name) <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="name-fields">
                            <input type="text" name="last_name" placeholder="例: 山田" class="form-input">
                            <input type="text" name="first_name" placeholder="例: 太郎" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        性別 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="gender" value="1" checked class="radio-input">
                                <span class="radio-text">男性</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="2" class="radio-input">
                                <span class="radio-text">女性</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="3" class="radio-input">
                                <span class="radio-text">その他</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        メールアドレス <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <input type="email" name="email" placeholder="例: test@example.com" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        電話番号 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="phone-fields">
                            <input type="text" name="phone1" placeholder="080" class="form-input phone-input">
                            <span class="phone-separator">-</span>
                            <input type="text" name="phone2" placeholder="1234" class="form-input phone-input">
                            <span class="phone-separator">-</span>
                            <input type="text" name="phone3" placeholder="5678" class="form-input phone-input">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        住所 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        建物名
                    </label>
                    <div class="form-input-container">
                        <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        お問い合わせの種類 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="select-wrapper">
                            <select name="category_id" class="form-select">
                                <option value="">選択してください</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->content }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        お問い合わせ内容 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <textarea name="detail" placeholder="お問い合わせ内容をご記載ください" class="form-textarea"></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-button">確認画面</button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
