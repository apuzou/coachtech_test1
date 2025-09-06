<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ完了</title>
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
</head>

<body>
    <div class="background-text">Thank you</div>
    <div class="thanks-content">
        <div class="main-message">お問い合わせありがとうございました</div>
        <a href="{{ route('contact.index') }}" class="home-button">HOME</a>
    </div>
</body>

</html>
