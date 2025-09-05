<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * ユーザーデータのテスト用ファクトリークラス
 *
 * このクラスは、管理者ユーザーのテストデータやダミーデータを自動生成します。
 * LaravelのFakerライブラリを使用して、リアルなデータに近いテストデータを作成します。
 *
 * 主な機能：
 * - ランダムなユーザー名生成
 * - ランダムなメールアドレス生成（重複なし）
 * - セキュアなパスワードのハッシュ生成
 * - メール認証状態の設定
 * - Remember Tokenの生成
 */
class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),

            'email' => $this->faker->unique()->safeEmail(),

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),
        ];
    }

    /**
     * メールアドレスが未認証状態のユーザーを生成するためのメソッド
     *
     * このメソッドを使用すると、email_verified_atがnullに設定され、
     * メール認証が必要なユーザーを作成できます。
     *
     * 使用例：
     * User::factory()->unverified()->create(); // メール未認証のユーザーを作成
     *
     * 注意：
     * メール認証機能が有効なアプリケーションでは、
     * このユーザーは特定の機能にアクセスできない場合があります。
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        // state()メソッドでデフォルトの属性を上書き
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
