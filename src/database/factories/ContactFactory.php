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
 * - ランダムな日本人の名前生成
 * - ランダムなメールアドレス生成（重複なし）
 * - 日本の47都道府県からランダムに選択した住所生成
 * - リアルな電話番号形式の生成
 * - カテゴリーとのリレーションを考慮したデータ生成
 * 
 * 使用例：
 * Contact::factory()->create();        // 1件のテストデータ作成
 * Contact::factory()->count(10)->create(); // 10件のテストデータ作成
 */
class ContactFactory extends Factory
{
    /**
     * お問い合わせモデルのデフォルト状態（テストデータの雛形）を定義
     * 
     * このメソッドでは、Fakerライブラリを使用してリアルなテストデータを生成します。
     * 日本の実情に合わせたデータ（都道府県、電話番号形式等）を生成します。
     * 
     * 生成されるデータの種類：
     * - ランダムな名前（姓・名）
     * - ランダムな性別（1:男性, 2:女性, 3:その他）
     * - ユニークなメールアドレス
     * - 日本の電話番号形式（xxx-xxxx-xxxx）
     * - 47都道府県からランダム選択した住所
     * - オプショナルな建物名（70%の確率で生成）
     * - ランダムなお問い合わせ内容（段落形式）
     * - 既存カテゴリーからランダム選択
     * 
     * @return array<string, mixed> テストデータの配列
     */
    public function definition()
    {
        // 性別の選択肢：1=男性, 2=女性, 3=その他
        $genders = [1, 2, 3];
        // 日本の47都道府県一覧（リアルな住所データを生成するため）
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

            // 名前：Fakerで生成されたランダムな名前
            'first_name' => $this->faker->firstName(),   // 名（例：太郎）
            'last_name' => $this->faker->lastName(),     // 姓（例：山田）

            // 性別：上記で定義した性別配列からランダム選択
            'gender' => $this->faker->randomElement($genders),

            // メールアドレス：重複しない安全なメールアドレスを生成
            'email' => $this->faker->unique()->safeEmail(),

            // 電話番号：日本の電話番号形式（xxx-xxxx-xxxx）で生成
            // numerify()は#をランダムな数字に置き換える
            'tell' => $this->faker->numerify('0##-####-####'),

            // 住所：都道府県 + 市区町村 + 街住所を組み合わせ
            'address' => $this->faker->randomElement($prefectures) . $this->faker->city() . $this->faker->streetAddress(),

            // 建物名：70%の確率で生成、マンション名等を想定
            // optional(0.7)は70%の確率で値を生成、30%は空になる
            'building' => $this->faker->optional(0.7)->buildingNumber() . $this->faker->optional(0.7)->company(),

            // お問い合わせ内容：3文の段落でランダムなテキストを生成
            'detail' => $this->faker->paragraph(3),
        ];
    }
}
