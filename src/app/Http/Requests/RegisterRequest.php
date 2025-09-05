<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ユーザー登録フォームのバリデーションルールを定義するリクエストクラス
 *
 * このクラスは、ユーザー登録フォームから送信されたデータの
 * バリデーション（入力値検証）を自動的に実行します。
 *
 * 主な機能：
 * - ユーザー名の必須チェック
 * - メールアドレスの必須チェックと形式チェック
 * - パスワードの必須チェック
 * - カスタムエラーメッセージの表示
 *
 * 注意：
 * このバリデーションは基本的なチェックのみで、
 * メールアドレスの重複チェックはAuthControllerで実装
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',

            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',

            'password.required' => 'パスワードを入力してください',
        ];
    }
}
