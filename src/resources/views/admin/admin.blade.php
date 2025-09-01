<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - FashionablyLate</title>
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

            <!-- 検索・フィルタリングセクション -->
            <div class="search-section">
                <form method="GET" action="{{ route('admin.index') }}" class="search-form">
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
                                    <a href="{{ route('admin.show', $contact) }}" class="detail-button">詳細</a>
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
</body>

</html>
