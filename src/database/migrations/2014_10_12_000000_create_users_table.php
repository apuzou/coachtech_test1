<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * このマイグレーションは、管理者ユーザーの認証情報を保存する
 * usersテーブルをデータベースに作成します。
 *
 * テーブルの目的：
 * - 管理者のログイン情報を管理
 * - メール認証機能のサポート
 * - ログイン状態の維持（Remember Token）
 * - セキュアなパスワード管理
 *
 * セキュリティ特徴：
 * - メールアドレスの一意性制約
 * - パスワードのハッシュ化保存
 * - メール認証機能のサポート
 */

class CreateUsersTable extends Migration
{
    /**
     * セキュリティ機能：
     * - unique()制約により、同じメールアドレスでの重複登録を防止
     * - email_verified_atでメール認証状態を管理（NULL=未認証、日時=認証済み）
     * - rememberTokenで「ログイン状態を保持する」機能をサポート
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('email')->unique();

            // メール認証日時：NULL=未認証、日時が入っていれば認証済み
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            $table->rememberToken();

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
