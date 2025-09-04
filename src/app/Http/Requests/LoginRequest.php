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
 * 
 * 注意：
 * ログイン時はパスワードの強度チェックは行わない
 * （既存ユーザーのログインなので、登録時のルールとは異なる）
 */
class LoginRequest extends FormRequest
{
    /**
     * このリクエストを実行する権限があるかどうかを判定
     * 
     * ログインフォームは誰でもアクセスできるため、常にtrueを返します。
     * 
     * @return bool 権限がある場合はtrue、ない場合はfalse
     */
    public function authorize(): bool
    {
        return true;  // 誰でもログインフォームを使用可能
    }

    /**
     * リクエストに適用するバリデーションルールを定義
     * 
     * ログイン時は必要最小限のチェックのみ実行し、
     * ユーザーの使いやすさを優先します。
     * 
     * 使用しているバリデーションルール：
     * - required: 必須入力
     * - email: メールアドレス形式
     * 
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',     // メールアドレス：必須入力かつメール形式
            'password' => 'required',        // パスワード：必須入力（強度チェックはなし）
        ];
    }

    /**
     * バリデーションルール用のカスタムエラーメッセージを定義
     * 
     * Laravelのデフォルトエラーメッセージは英語なので、
     * 日本語のユーザーフレンドリーなメッセージに置き換えます。
     * 
     * メッセージのキー形式：「フィールド名.ルール名」
     * 例：email.required = メールアドレスフィールドのrequiredルールに対するメッセージ
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // メールアドレス関連のエラーメッセージ
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',

            // パスワード関連のエラーメッセージ
            'password.required' => 'パスワードを入力してください',
        ];
    }
}
