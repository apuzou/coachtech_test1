<?php

/**
 * Webルート定義ファイル
 *
 * 主な機能グループ：
 * 1. お問い合わせフォーム関連（誰でもアクセス可能）
 * 2. 認証関連（ログイン・ログアウト・ユーザー登録）
 * 3. 管理画面関連（ログイン済みユーザーのみアクセス可能）
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// =============================================================================
// お問い合わせフォーム関連ルート（誰でもアクセス可能）
// =============================================================================

/**
 * トップページ（お問い合わせフォーム表示)
 * 処理: ContactControllerのindexメソッドでカテゴリー一覧を取得してフォームを表示
 */
Route::get('/', [ContactController::class, 'index'])->name('contact.index');

/**
 * お問い合わせ確認画面表示
 * 処理: ContactControllerのconfirmメソッドでフォームデータをバリデーションして確認画面を表示
 * バリデーション: ContactRequestクラスで自動実行
 */
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');

/**
 * お問い合わせデータ保存（送信処理）
 * 処理: ContactControllerのstoreメソッドでデータベースに保存してサンクスページにリダイレクト
 */
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/**
 * お問い合わせ修正処理（確認画面からフォームに戻る）
 * 処理: ContactControllerのeditメソッドで入力データをセッションに保存してフォームに戻る
 */
Route::post('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit');

/**
 * お問い合わせ送信完了ページ
 * 処理: ContactControllerのthanksメソッドでサンクスページを表示
 */
Route::get('/contact/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

// =============================================================================
// 認証関連ルート（ログイン・ログアウト・ユーザー登録）
// =============================================================================

/**
 * ゲストユーザー（ログインしていないユーザー）のみアクセス可能なルートグループ
 * ミドルウェア 'guest' により、ログイン済みユーザーはアクセスできない
 */
Route::middleware(['guest'])->group(function () {
    /**
     * ログインフォーム表示
     * 処理: 無名関数で直接login.blade.phpを表示
     */
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    /**
     * ログイン処理
     * 処理: AuthControllerのloginメソッドでメールアドレスとパスワードで認証
     */
    Route::post('/login', [AuthController::class, 'login']);

    /**
     * ユーザー登録フォーム表示
     * 処理: 無名関数で直接register.blade.phpを表示
     */
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    /**
     * ユーザー登録処理
     * 処理: AuthControllerのregisterメソッドで新しいユーザーアカウントを作成
     */
    Route::post('/register', [AuthController::class, 'register']);
});

/**
 * ログアウト処理
 * 処理: AuthControllerのlogoutメソッドでログアウトしてトップページにリダイレクト
 * 注意: CSRF攻撃を防ぐためPOSTメソッドで実装
 */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =============================================================================
// 管理画面関連ルート（ログイン済みユーザーのみアクセス可能）
// =============================================================================

/**
 * 認証済みユーザーのみアクセス可能な管理画面ルートグループ
 * ミドルウェア 'auth' により、ログインしていないユーザーは自動的にログインページにリダイレクトされる
 */
Route::middleware(['auth'])->group(function () {
    /**
     * 管理画面メインページ（お問い合わせ一覧）
     * 処理: AdminControllerのindexメソッドでお問い合わせ一覧を表示
     * 機能: 検索・フィルター・ページネーション・モーダル表示
     */
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    /**
     * お問い合わせ削除処理
     * 処理: AdminControllerのdestroyメソッドで指定されたお問い合わせを削除
     * パラメータ: {contact} - 削除するお問い合わせのID（Laravelのモデルバインディング機能で自動取得）
     * 注意: CSRF攻撃を防ぐためDELETEメソッドで実装
     */
    Route::delete('/admin/contact/{contact}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
