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
 */
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class,  // 1. お問い合わせの種類（カテゴリー）データを投入
            ContactSeeder::class,   // 2. テスト用お問い合わせデータを投入
        ]);
    }
}
