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
 * 
 * 使用例：
 * User::factory()->create();                    // 1件のテストユーザー作成
 * User::factory()->count(5)->create();         // 5件のテストユーザー作成
 * User::factory()->unverified()->create();     // メール未認証のユーザー作成
 */
class UserFactory extends Factory
{
    /**
     * ユーザーモデルのデフォルト状態（テストデータの雛形）を定義
     * 
     * このメソッドでは、管理者ユーザーのテストデータを生成します。
     * セキュリティを考慮し、パスワードはハッシュ化された状態で生成します。
     * 
     * 生成されるデータの種類：
     * - ランダムなユーザー名
     * - ユニークなメールアドレス
     * - メール認証済み状態（デフォルト）
     * - ハッシュ化されたパスワード（デフォルトは"password"）
     * - ランダムなRemember Token（ログイン維持用）
     * 
     * @return array<string, mixed> テストデータの配列
     */
    public function definition()
    {
        return [
            // ユーザー名：Fakerで生成されたランダムな名前
            'name' => $this->faker->name(),

            // メールアドレス：重複しない安全なメールアドレスを生成
            'email' => $this->faker->unique()->safeEmail(),

            // メール認証日時：デフォルトで認証済み状態に設定
            'email_verified_at' => now(),

            // パスワード：ハッシュ化された"password"文字列
            // このハッシュは"password"をbcryptでハッシュ化したもの
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

            // Remember Token：ログイン状態を維持するための10文字のランダム文字列
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
                'email_verified_at' => null,  // メール認証日時をnullに設定（未認証状態）
            ];
        });
    }
}
