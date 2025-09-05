{{-- 
    管理画面メインページ（admin.blade.php）
    
    このファイルの役割：
    - 管理者がお問い合わせ一覧を閲覧・管理するための画面
    - 検索・フィルタリング機能
    - ページネーション機能
    - 各お問い合わせの詳細表示（モーダル）
    - お問い合わせの削除機能
    
    主な機能：
    - 名前・メール・性別・カテゴリーでの検索・絞り込み
    - お問い合わせ一覧のテーブル表示
    - 詳細ボタンクリックでモーダル表示（CSS-only modal）
    - モーダル内での削除機能
    - ページネーション（7件ずつ表示）
    - フラッシュメッセージ表示（削除成功・エラー）
    
    技術的な特徴：
    - CSS-onlyモーダル（:target疑似クラス使用）
    - 各お問い合わせごとに個別のモーダルHTML生成
    - フォームでの削除処理（DELETE method）
    - JavaScriptを使わないモーダル実装
    - レスポンシブデザイン対応
--}}
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF攻撃防止用のメタタグ（現在は未使用だが、将来のJavaScript機能用に保持） --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>管理画面 - FashionablyLate</title>
    {{-- 管理画面専用のCSSファイルを読み込み --}}
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
            <h1 class="page-title">Admin</h1>

            <!-- フラッシュメッセージ -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <!-- 検索・フィルタリングセクション -->
            <div class="search-section">
                <form method="GET" action="{{ route('admin.index') }}" class="search-form">
                    @csrf
                    <div class="search-filters">
                        <input type="text" name="search" class="search-input" placeholder="名前やメールアドレスを入力してください"
                            value="{{ request('search') }}">

                        <select name="gender" class="filter-select">
                            <option value="">性別</option>
                            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                        </select>

                        <select name="category_id" class="filter-select">
                            <option value="">お問い合わせの種類</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->content }}
                                </option>
                            @endforeach
                        </select>

                        <input type="date" name="date" class="filter-select" value="{{ request('date') }}">

                        <button type="submit" class="search-button">検索</button>
                        <a href="{{ route('admin.index') }}" class="reset-button">リセット</a>
                    </div>
                </form>
            </div>

            <!-- エクスポートボタンとページネーション -->
            <div class="toolbar-section">
                <div class="export-section">
                    <button class="export-button">エクスポート</button>
                </div>

                @if ($contacts->hasPages())
                    <div class="pagination-container">
                        {{ $contacts->appends(request()->query())->links('pagination::custom') }}
                    </div>
                @endif
            </div>

            <!-- データテーブル -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>お名前</th>
                            <th>性別</th>
                            <th>メールアドレス</th>
                            <th>お問い合わせの種類</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr>
                                <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                                <td>{{ \App\Http\Controllers\AdminController::getGenderText($contact->gender) }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->category->content ?? '未選択' }}</td>
                                <td>
                                    <a href="#modal-{{ $contact->id }}" class="detail-button">詳細</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="no-data">データがありません</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- モーダルウィンドウ -->
    @foreach ($contacts as $contact)
        <div id="modal-{{ $contact->id }}" class="modal">
            <div class="modal-content">
                <a href="#" class="close">&times;</a>
                <div class="modal-detail-panel">
                    <div class="modal-detail-row">
                        <div class="modal-detail-label">お名前</div>
                        <div class="modal-detail-value">{{ $contact->last_name }} {{ $contact->first_name }}</div>
                    </div>

                    <div class="modal-detail-row">
                        <div class="modal-detail-label">性別</div>
                        <div class="modal-detail-value">
                            {{ \App\Http\Controllers\AdminController::getGenderText($contact->gender) }}
                        </div>
                    </div>

                    <div class="modal-detail-row">
                        <div class="modal-detail-label">メールアドレス</div>
                        <div class="modal-detail-value">{{ $contact->email }}</div>
                    </div>

                    <div class="modal-detail-row">
                        <div class="modal-detail-label">電話番号</div>
                        <div class="modal-detail-value">{{ $contact->tell }}</div>
                    </div>

                    <div class="modal-detail-row">
                        <div class="modal-detail-label">住所</div>
                        <div class="modal-detail-value">{{ $contact->address }}</div>
                    </div>

                    @if (!empty($contact->building))
                        <div class="modal-detail-row">
                            <div class="modal-detail-label">建物名</div>
                            <div class="modal-detail-value">{{ $contact->building }}</div>
                        </div>
                    @endif

                    <div class="modal-detail-row">
                        <div class="modal-detail-label">お問い合わせの種類</div>
                        <div class="modal-detail-value">{{ $contact->category->content ?? '未選択' }}</div>
                    </div>

                    <div class="modal-detail-row">
                        <div class="modal-detail-label">お問い合わせ内容</div>
                        <div class="modal-detail-value">{{ $contact->detail }}</div>
                    </div>
                </div>

                <div class="modal-delete-section">
                    <form method="POST" action="{{ route('admin.destroy', $contact) }}"
                        onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button">削除</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
