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
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'gender' => 'required|integer|in:1,2,3',
            'email' => 'required|email|max:255',
            'phone1' => 'required|digits_between:1,5',
            'phone2' => 'required|digits_between:1,5',
            'phone3' => 'required|digits_between:1,5',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',

            'gender.required' => '性別を選択してください',

            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',

            'phone1.required' => '電話番号を入力してください',
            'phone1.digits_between' => '電話番号は5桁までの数字で入力してください',
            'phone2.required' => '電話番号を入力してください',
            'phone2.digits_between' => '電話番号は5桁までの数字で入力してください',
            'phone3.required' => '電話番号を入力してください',
            'phone3.digits_between' => '電話番号は5桁までの数字で入力してください',

            'address.required' => '住所を入力してください',

            'category_id.required' => 'お問い合わせの種類を選択してください',

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
