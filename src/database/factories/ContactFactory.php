<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * お問い合わせデータのテスト用ファクトリークラス
 *
 * このクラスは、お問い合わせのテストデータやダミーデータを自動生成します。
 * LaravelのFakerライブラリを使用して、リアルなデータに近いテストデータを作成します。
 *
 * 主な機能：
 * - ランダムな名前生成
 * - ランダムなメールアドレス生成（重複なし）
 * - 日本の47都道府県からランダムに選択した住所生成
 * - リアルな電話番号形式の生成
 * - カテゴリーとのリレーションを考慮したデータ生成
 */
class ContactFactory extends Factory
{
    public function definition()
    {
        // 性別の選択肢：1=男性, 2=女性, 3=その他
        $genders = [1, 2, 3];
        $prefectures = [
            '北海道',
            '青森県',
            '岩手県',
            '宮城県',
            '秋田県',
            '山形県',
            '福島県',
            '茨城県',
            '栃木県',
            '群馬県',
            '埼玉県',
            '千葉県',
            '東京都',
            '神奈川県',
            '新潟県',
            '富山県',
            '石川県',
            '福井県',
            '山梨県',
            '長野県',
            '岐阜県',
            '静岡県',
            '愛知県',
            '三重県',
            '滋賀県',
            '京都府',
            '大阪府',
            '兵庫県',
            '奈良県',
            '和歌山県',
            '鳥取県',
            '島根県',
            '岡山県',
            '広島県',
            '山口県',
            '徳島県',
            '香川県',
            '愛媛県',
            '高知県',
            '福岡県',
            '佐賀県',
            '長崎県',
            '熊本県',
            '大分県',
            '宮崎県',
            '鹿児島県',
            '沖縄県'
        ];

        // テストデータの各項目をランダム生成して返す
        return [
            // カテゴリーID：既存のカテゴリーからランダムに1つ選択
            'category_id' => Category::inRandomOrder()->first()->id,

            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),

            'gender' => $this->faker->randomElement($genders),

            'email' => $this->faker->unique()->safeEmail(),

            // numerify()は#をランダムな数字に置き換える
            'tell' => $this->faker->numerify('0##-####-####'),

            // 住所：都道府県 + 市区町村 + 街住所を組み合わせ
            'address' => $this->faker->randomElement($prefectures) . $this->faker->city() . $this->faker->streetAddress(),

            // 建物名：70%の確率で生成、マンション名等を想定
            // optional(0.7)は70%の確率で値を生成、30%は空になる
            'building' => $this->faker->optional(0.7)->buildingNumber() . $this->faker->optional(0.7)->company(),

            'detail' => $this->faker->paragraph(3),
        ];
    }
}
