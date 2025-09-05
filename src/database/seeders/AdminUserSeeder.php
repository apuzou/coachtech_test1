<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * 管理者ユーザーの初期データを投入するシーダークラス
 *
 * このクラスは、管理画面にアクセスするための管理者アカウントを
 * データベースに作成します。
 *
 * 作成される管理者アカウント：
 * - ユーザー名: admin
 * - メールアドレス: admin@example.com
 * - パスワード: password
 *
 * セキュリティ対策：
 * - パスワードはHash::make()でハッシュ化して保存
 * - 本番環境ではパスワードの変更を必ず実行すること
 */
class AdminUserSeeder extends Seeder
{
    /**
     * 管理者ユーザーのアカウントをデータベースに作成する処理
     *
     * このメソッドでは、事前に定義した管理者アカウント情報を使用して、
     * データベースに新しいユーザーレコードを作成します。
     *
     * セキュリティの考慮事項：
     * - Hash::make()でパスワードをハッシュ化して保存
     * - プレーンテキストのパスワードはデータベースに保存されない
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
