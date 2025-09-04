<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Providers\RouteServiceProvider;

/**
 * 認証機能（ログイン・ログアウト・ユーザー登録）を管理するコントローラー
 * 
 * このクラスは、アプリケーションのユーザー認証に関するすべての処理を担当します。
 * 
 * 主な機能：
 * - ユーザーログイン処理（メールアドレスとパスワードで認証）
 * - 新規ユーザー登録処理（アカウント作成と自動ログイン）
 * - ユーザーログアウト処理（セッション無効化とセキュリティ対策）
 * - エラーハンドリング（重複メールアドレス、データベースエラー等）
 */
class AuthController extends Controller
{
  /**
   * ユーザーログイン処理
   * 
   * 流れ：
   * 1. ログインフォームから送信されたメールアドレスとパスワードを取得
   * 2. データベースのユーザー情報と照合して認証を試行
   * 3. 認証成功時：セッションを再生成して管理画面にリダイレクト
   * 4. 認証失敗時：エラーメッセージと共にログインフォームに戻る
   * 
   * セキュリティ対策：
   * - パスワードはハッシュ化されて保存されている
   * - セッションフィクセーション攻撃を防ぐためセッションIDを再生成
   */
  public function login(LoginRequest $request)
  {
    // ログインフォームからメールアドレスとパスワードを取得
    $credentials = $request->only('email', 'password');

    // Laravelの認証機能を使ってユーザー認証を試行
    // Auth::attempt()はパスワードを自動でハッシュ化して比較
    if (Auth::attempt($credentials)) {
      // 認証成功時：セキュリティ対策としてセッションIDを再生成
      $request->session()->regenerate();

      // 管理画面にリダイレクト（元々アクセスしようとしたページがあればそちらへ）
      return redirect()->intended(RouteServiceProvider::HOME);
    }

    // 認証失敗時：エラーメッセージと共にログインフォームに戻る
    return back()
      ->withInput($request->only('email'))  // メールアドレスは再入力を省くため保持
      ->withErrors([
        'email' => '提供された認証情報が正しくありません。',  // ユーザーフレンドリーなエラーメッセージ
      ]);
  }

  /**
   * 新規ユーザー登録処理
   * 
   * 流れ：
   * 1. 登録フォームから送信されたユーザー情報を取得
   * 2. パスワードをハッシュ化してセキュリティを確保
   * 3. データベースに新しいユーザーレコードを作成
   * 4. 作成成功時：自動ログインして管理画面にリダイレクト
   * 5. エラー発生時：適切なエラーメッセージでユーザーに通知
   * 
   * エラーハンドリング：
   * - メールアドレス重複エラー（コード23000）
   * - その他のデータベースエラーのハンドリング
   * 
   * セキュリティ対策：
   * - パスワードはハッシュ化して保存（Hash::make()使用）
   * - メールアドレスのUNIQUE制約で重複登録を防止
   */
  public function register(RegisterRequest $request)
  {
    try {
      // 新しいユーザーアカウントをデータベースに作成
      $user = User::create([
        'name' => $request->name,                           // ユーザー名
        'email' => $request->email,                         // メールアドレス
        'password' => Hash::make($request->password),       // パスワードをハッシュ化して保存
      ]);

      // 登録後に自動でログイン状態にする（UXの向上）
      auth()->login($user);

      // 管理画面にリダイレクト
      return redirect(RouteServiceProvider::HOME);
    } catch (QueryException $e) {
      // データベースエラーの種類を判定して適切なエラーメッセージを表示

      if ($e->getCode() == 23000) {
        // エラーコード23000：UNIQUE制約違反（メールアドレスが既に存在）
        return back()
          ->withInput($request->only('name'))  // ユーザー名は再入力を省くため保持
          ->withErrors([
            'email' => 'このメールアドレスは既に使用されています。',
          ]);
      }

      // その他のデータベースエラー（サーバーエラー、接続エラー等）
      return back()
        ->withInput($request->only('name', 'email'))  // ユーザー名とメールアドレスを保持
        ->withErrors([
          'email' => '登録中にエラーが発生しました。しばらく時間をおいて再度お試しください。',
        ]);
    }
  }

  /**
   * ユーザーログアウト処理
   * 
   * 流れ：
   * 1. 現在ログイン中のユーザーをログアウト状態に変更
   * 2. セッションデータを完全に破棄してセキュリティを確保
   * 3. CSRFトークンを再生成してセッションハイジャックを防止
   * 4. トップページにリダイレクト
   * 
   * セキュリティ対策：
   * - セッションの完全な無効化でセッションハイジャックを防止
   * - CSRFトークンの再生成でCSRF攻撃を防止
   * - ログアウト後は認証が必要なページにアクセスできない
   */
  public function logout(Request $request)
  {
    // ユーザーをログアウト状態に変更
    Auth::logout();

    // セッションデータを完全に破棄（セキュリティ対策）
    $request->session()->invalidate();

    // CSRFトークンを再生成してセッションハイジャックを防止
    $request->session()->regenerateToken();

    // トップページ（お問い合わせフォーム）にリダイレクト
    return redirect(RouteServiceProvider::LOGOUT_REDIRECT);
  }
}
