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
 * 
 * 使用方法：
 * php artisan db:seed --class=AdminUserSeeder
 * または
 * DatabaseSeeder.phpでこのクラスを呼び出す
 * 
 * 注意：
 * このシーダーは本番環境でも使用できますが、
 * セキュリティのためにパスワードの変更を必ず行ってください。
 */
class AdminUserSeeder extends Seeder
{
    /**
     * 管理者ユーザーのアカウントをデータベースに作成する処理
     * 
     * このメソッドでは、事前に定義した管理者アカウント情報を使用して、
     * データベースに新しいユーザーレコードを作成します。
     * 
     * 作成されるアカウント情報：
     * - name: 'admin' - 管理者として識別しやすいシンプルな名前
     * - email: 'admin@example.com' - ログインIDとして使用するメールアドレス
     * - password: 'password' - デフォルトパスワード（ハッシュ化されて保存）
     * 
     * セキュリティの考慮事項：
     * - Hash::make()でパスワードをハッシュ化して保存
     * - プレーンテキストのパスワードはデータベースに保存されない
     * 
     * 重要な注意事項：
     * 本番環境では、このデフォルトパスワードを必ず変更してください。
     * セキュリティ上のリスクを防ぐため、推測されにくい強力なパスワードに変更してください。
     * 
     * @return void
     */
    public function run(): void
    {
        // 管理者アカウントをデータベースに作成
        User::create([
            'name' => 'admin',                           // 管理者のユーザー名
            'email' => 'admin@example.com',              // ログイン用メールアドレス
            'password' => Hash::make('password'),        // パスワードをハッシュ化して保存
        ]);

        // 注意：上記の情報でログインできます
        // メールアドレス: admin@example.com
        // パスワード: password
        // 本番環境では必ずパスワードを変更してください！
    }
}
