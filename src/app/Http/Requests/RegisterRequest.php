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
    /**
     * このリクエストを実行する権限があるかどうかを判定
     * 
     * ユーザー登録フォームは誰でもアクセスできるため、常にtrueを返します。
     * 
     * @return bool 権限がある場合はtrue、ない場合はfalse
     */
    public function authorize(): bool
    {
        return true;  // 誰でもユーザー登録フォームを使用可能
    }

    /**
     * リクエストに適用するバリデーションルールを定義
     * 
     * ユーザー登録時に必要な基本的なチェックを実行します。
     * より複雑なチェック（メール重複等）はAuthControllerで実装しています。
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
            'name' => 'required',            // ユーザー名：必須入力
            'email' => 'required|email',     // メールアドレス：必須入力かつメール形式
            'password' => 'required',        // パスワード：必須入力（強度チェックはフロントエンドで実装できる）
        ];
    }

    /**
     * バリデーションルール用のカスタムエラーメッセージを定義
     * 
     * Laravelのデフォルトエラーメッセージは英語なので、
     * 日本語のユーザーフレンドリーなメッセージに置き換えます。
     * 
     * メッセージのキー形式：「フィールド名.ルール名」
     * 例：name.required = ユーザー名フィールドのrequiredルールに対するメッセージ
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // ユーザー名関連のエラーメッセージ
            'name.required' => 'お名前を入力してください',

            // メールアドレス関連のエラーメッセージ
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',

            // パスワード関連のエラーメッセージ
            'password.required' => 'パスワードを入力してください',
        ];
    }
}
