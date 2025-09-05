<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ログインフォームのバリデーションルールを定義するリクエストクラス
 *
 * このクラスは、ログインフォームから送信されたデータの
 * バリデーション（入力値検証）を自動的に実行します。
 *
 * 主な機能：
 * - メールアドレスの必須チェックと形式チェック
 * - パスワードの必須チェック
 * - カスタムエラーメッセージの表示
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',

            'password.required' => 'パスワードを入力してください',
        ];
    }
}
