<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
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
                <div class="form-group name-form-group">
                    <label class="form-label">
                        お名前 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="name-fields">
                            <input type="text" name="last_name" placeholder="例:山田"
                                class="form-input @error('last_name') error-input @enderror"
                                value="{{ session('old_input.last_name') ?? old('last_name') }}">
                            <input type="text" name="first_name" placeholder="例:太郎"
                                class="form-input @error('first_name') error-input @enderror"
                                value="{{ session('old_input.first_name') ?? old('first_name') }}">
                        </div>
                        @error('last_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        @error('first_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        性別 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="gender" value="1"
                                    {{ (session('old_input.gender') ?? old('gender', '1')) == '1' ? 'checked' : '' }}
                                    class="radio-input">
                                <span class="radio-text">男性</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="2"
                                    {{ (session('old_input.gender') ?? old('gender')) == '2' ? 'checked' : '' }}
                                    class="radio-input">
                                <span class="radio-text">女性</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="3"
                                    {{ (session('old_input.gender') ?? old('gender')) == '3' ? 'checked' : '' }}
                                    class="radio-input">
                                <span class="radio-text">その他</span>
                            </label>
                        </div>
                    </div>
                    @error('gender')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        メールアドレス <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <input type="email" name="email" placeholder="例: test@example.com"
                            class="form-input @error('email') error-input @enderror"
                            value="{{ session('old_input.email') ?? old('email') }}">
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        電話番号 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="phone-fields">
                            <input type="text" name="phone1" placeholder="080"
                                class="form-input phone-input @error('phone') error-input @enderror"
                                value="{{ session('old_input.phone1') ?? old('phone1') }}">
                            <span class="phone-separator">-</span>
                            <input type="text" name="phone2" placeholder="1234"
                                class="form-input phone-input @error('phone') error-input @enderror"
                                value="{{ session('old_input.phone2') ?? old('phone2') }}">
                            <span class="phone-separator">-</span>
                            <input type="text" name="phone3" placeholder="5678"
                                class="form-input phone-input @error('phone') error-input @enderror"
                                value="{{ session('old_input.phone3') ?? old('phone3') }}">
                        </div>
                    </div>
                    {{-- 電話番号の統一されたエラーメッセージのみ表示 --}}
                    @if ($errors->has('phone1') || $errors->has('phone2') || $errors->has('phone3'))
                        @if (!$errors->has('phone'))
                            {{-- 個別エラーがあるが統一エラーがない場合、統一エラーを追加 --}}
                            @if (empty(old('phone1')) && empty(old('phone2')) && empty(old('phone3')))
                                <div class="error-message">電話番号を入力してください</div>
                            @else
                                <div class="error-message">電話番号は5桁までの数字で入力してください</div>
                            @endif
                        @else
                            {{-- 統一エラーがある場合はそれを表示 --}}
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        @endif
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">
                        住所 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3"
                            class="form-input @error('address') error-input @enderror"
                            value="{{ session('old_input.address') ?? old('address') }}">
                    </div>
                    @error('address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        建物名
                    </label>
                    <div class="form-input-container">
                        <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" class="form-input"
                            value="{{ session('old_input.building') ?? old('building') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        お問い合わせの種類 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <div class="select-wrapper">
                            <select name="category_id"
                                class="form-select @error('category_id') error-input @enderror">
                                <option value="">選択してください</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (session('old_input.category_id') ?? old('category_id')) == $category->id ? 'selected' : '' }}>
                                        {{ $category->content }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('category_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        お問い合わせ内容 <span class="required">※</span>
                    </label>
                    <div class="form-input-container">
                        <textarea name="detail" placeholder="お問い合わせ内容をご記載ください" class="form-textarea @error('detail') error-input @enderror">{{ session('old_input.detail') ?? old('detail') }}</textarea>
                    </div>
                    @error('detail')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-button">確認画面</button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
