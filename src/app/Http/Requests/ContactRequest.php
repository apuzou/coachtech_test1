<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * お問い合わせフォームのバリデーションルールを定義するリクエストクラス
 * 
 * このクラスは、お問い合わせフォームから送信されたデータの
 * バリデーション（入力値検証）を自動的に実行します。
 * 
 * 主な機能：
 * - 必須項目のチェック
 * - メールアドレス形式のチェック
 * - 電話番号の桁数・形式チェック
 * - 文字数制限のチェック
 * - カスタムエラーメッセージの表示
 */
class ContactRequest extends FormRequest
{
    /**
     * このリクエストを実行する権限があるかどうかを判定
     * 
     * このメソッドでfalseを返すと、3番エラー（Forbidden）が発生します。
     * お問い合わせフォームは誰でもアクセスできるため、常にtrueを返します。
     * 
     * @return bool 権限がある場合はtrue、ない場合はfalse
     */
    public function authorize(): bool
    {
        return true;  // 誰でもお問い合わせフォームを使用可能
    }

    /**
     * リクエストに適用するバリデーションルールを定義
     * 
     * 各フィールドに対して、必須チェックや形式チェックなどの
     * バリデーションルールを設定します。
     * 
     * 使用しているバリデーションルール：
     * - required: 必須入力
     * - email: メールアドレス形式
     * - digits_between:1,5: 1桁から5桁の数字
     * - max:120: 最大120文字
     * 
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'last_name' => 'required',                    // 姓：必須入力
            'first_name' => 'required',                   // 名：必須入力
            'gender' => 'required',                       // 性別：必須選択
            'email' => 'required|email',                  // メールアドレス：必須入力かつメール形式
            'phone1' => 'required|digits_between:1,5',    // 電話番号1：必須かつ1-5桁の数字
            'phone2' => 'required|digits_between:1,5',    // 電話番号2：必須かつ1-5桁の数字
            'phone3' => 'required|digits_between:1,5',    // 電話番号3：必須かつ1-5桁の数字
            'address' => 'required',                      // 住所：必須入力
            'category_id' => 'required',                  // カテゴリーID：必須選択
            'detail' => 'required|max:120',               // お問い合わせ内容：必須入力かつ120文字以内
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
            // 名前関連のエラーメッセージ
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',

            // 性別関連のエラーメッセージ
            'gender.required' => '性別を選択してください',

            // メールアドレス関連のエラーメッセージ
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',

            // 電話番号関連のエラーメッセージ（各フィールド別）
            'phone1.required' => '電話番号を入力してください',
            'phone1.digits_between' => '電話番号は5桁までの数字で入力してください',
            'phone2.required' => '電話番号を入力してください',
            'phone2.digits_between' => '電話番号は5桁までの数字で入力してください',
            'phone3.required' => '電話番号を入力してください',
            'phone3.digits_between' => '電話番号は5桁までの数字で入力してください',

            // 住所関連のエラーメッセージ
            'address.required' => '住所を入力してください',

            // カテゴリー関連のエラーメッセージ
            'category_id.required' => 'お問い合わせの種類を選択してください',

            // お問い合わせ内容関連のエラーメッセージ
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問合せ内容は120文字以内で入力してください',
        ];
    }

    /**
     * バリデーターインスタンスのカスタマイズを行う
     * 
     * 基本的なバリデーションルールでは対応できない複雑なロジックを
     * このメソッドで追加します。
     * 
     * ここでは、電話番号の3つのフィールドに対して、
     * 個別のエラーメッセージではなく統一されたメッセージを表示します。
     * 
     * @param  \Illuminate\Validation\Validator  $validator バリデーターインスタンス
     * @return void
     */
    public function withValidator($validator)
    {
        // バリデーション実行後に追加で実行されるカスタムロジック
        $validator->after(function ($validator) {
            // 電話番号の3つのフィールドのいずれかにエラーがある場合
            if ($validator->errors()->has('phone1') || $validator->errors()->has('phone2') || $validator->errors()->has('phone3')) {
                // 統一されたエラーメッセージを追加
                if (empty($this->phone1) && empty($this->phone2) && empty($this->phone3)) {
                    // すべて空の場合：必須入力エラー
                    $validator->errors()->add('phone', '電話番号を入力してください');
                } else {
                    // 一部に入力があるが形式エラーの場合：形式エラー
                    $validator->errors()->add('phone', '電話番号は5桁までの数字で入力してください');
                }
            }
        });
    }
}
