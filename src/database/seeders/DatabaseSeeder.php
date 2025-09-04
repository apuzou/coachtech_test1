<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * データベースのメインシーダークラス
 * 
 * このクラスは、アプリケーションの初期データ投入を統括管理します。
 * 他のシーダークラスを呼び出し、適切な順序でデータを投入します。
 * 
 * 主な機能：
 * - カテゴリーデータの投入（お問い合わせの種類）
 * - テスト用お問い合わせデータの投入
 * - 必要に応じて管理者ユーザーの投入
 * 
 * 実行方法：
 * php artisan db:seed
 * または
 * php artisan migrate:fresh --seed
 * 
 * 注意：
 * シーダーはデータベースの既存データを上書きする可能性があります。
 * 本番環境での実行は注意が必要です。
 */
class DatabaseSeeder extends Seeder
{
    /**
     * アプリケーションのデータベースに初期データを投入するメイン処理
     * 
     * このメソッドでは、他のシーダークラスを適切な順序で呼び出します。
     * データの依存関係を考慮し、参照されるデータから先に投入します。
     * 
     * 実行順序の理由：
     * 1. CategorySeeder: お問い合わせの種類データを先に投入
     * 2. ContactSeeder: カテゴリーデータに依存するお問い合わせデータを投入
     * 
     * コメントアウトされたコードについて：
     * User::factory(10)->create() はテストユーザーの一括作成用です。
     * 管理者ユーザーは別途AdminUserSeederで作成することを推奨します。
     * 
     * @return void
     */
    public function run()
    {
        // テストユーザーの一括作成（必要に応じてコメントアウトを外す）
        // \App\Models\User::factory(10)->create();

        // 他のシーダークラスを順次実行
        $this->call([
            CategorySeeder::class,  // 1. お問い合わせの種類（カテゴリー）データを投入
            ContactSeeder::class,   // 2. テスト用お問い合わせデータを投入
            // AdminUserSeeder::class, // 3. 管理者ユーザーを投入（必要に応じて有効化）
        ]);
    }
}
