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

class AuthController extends Controller
{
  /**
   * ログイン処理
   */
  public function login(LoginRequest $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended(RouteServiceProvider::HOME);
    }

    return back()
      ->withInput($request->only('email'))
      ->withErrors([
        'email' => '提供された認証情報が正しくありません。',
      ]);
  }

  /**
   * ユーザー登録処理
   */
  public function register(RegisterRequest $request)
  {
    try {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);

      // 自動ログイン
      auth()->login($user);
      return redirect(RouteServiceProvider::HOME);
    } catch (QueryException $e) {
      if ($e->getCode() == 23000) {
        // 重複エントリーエラー（メールアドレスが既に存在）
        return back()
          ->withInput($request->only('name'))
          ->withErrors([
            'email' => 'このメールアドレスは既に使用されています。',
          ]);
      }

      // その他のデータベースエラー
      return back()
        ->withInput($request->only('name', 'email'))
        ->withErrors([
          'email' => '登録中にエラーが発生しました。しばらく時間をおいて再度お試しください。',
        ]);
    }
  }

  /**
   * ログアウト処理
   */
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect(RouteServiceProvider::LOGOUT_REDIRECT);
  }
}
