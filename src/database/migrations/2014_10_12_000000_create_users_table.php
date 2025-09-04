<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ユーザーテーブルを作成するマイグレーション
 * 
 * このマイグレーションは、管理者ユーザーの認証情報を保存する
 * usersテーブルをデータベースに作成します。
 * 
 * テーブルの目的：
 * - 管理者のログイン情報を管理
 * - メール認証機能のサポート
 * - ログイン状態の維持（Remember Token）
 * - セキュアなパスワード管理
 * 
 * テーブル構造：
 * - 基本情報：ユーザー名、メールアドレス
 * - 認証情報：パスワード、メール認証状態
 * - セッション管理：Remember Token
 * - システム情報：作成日時、更新日時
 * 
 * セキュリティ特徴：
 * - メールアドレスの一意性制約
 * - パスワードのハッシュ化保存
 * - メール認証機能のサポート
 * 
 * ファイル名の意味：
 * 2014_10_12_000000 = Laravelの標準マイグレーションのタイムスタンプ
 * 他のテーブルから参照される可能性があるため、最初に実行されます。
 */
class CreateUsersTable extends Migration
{
    /**
     * マイグレーションを実行してusersテーブルを作成する処理
     * 
     * このメソッドは、php artisan migrateコマンドで実行されます。
     * Laravelの認証システムに必要な標準的なカラム構成でテーブルを作成します。
     * 
     * カラムの詳細説明：
     * - id(): 主キー、自動連番、UNSIGNED BIGINT、AUTO_INCREMENT
     * - string('name'): ユーザー名、VARCHAR(255)、NOT NULL
     * - string('email')->unique(): メールアドレス、VARCHAR(255)、NOT NULL、UNIQUE
     * - timestamp('email_verified_at')->nullable(): メール認証日時、TIMESTAMP、NULL可
     * - string('password'): パスワード（ハッシュ化済み）、VARCHAR(255)、NOT NULL
     * - rememberToken(): Remember Token、VARCHAR(100)、NULL可
     * - timestamps(): created_atとupdated_atカラムを自動作成
     * 
     * セキュリティ機能：
     * - unique()制約により、同じメールアドレスでの重複登録を防止
     * - email_verified_atでメール認証状態を管理（NULL=未認証、日時=認証済み）
     * - rememberTokenで「ログイン状態を保持する」機能をサポート
     * 
     * @return void
     */
    public function up()
    {
        // 'users'という名前のテーブルを作成
        Schema::create('users', function (Blueprint $table) {
            // 主キー：自動連番のIDカラムを作成
            $table->id();

            // ユーザー名：管理画面で表示される名前
            $table->string('name');

            // メールアドレス：ログインIDとして使用、一意性制約付き
            $table->string('email')->unique();

            // メール認証日時：NULL=未認証、日時が入っていれば認証済み
            $table->timestamp('email_verified_at')->nullable();

            // パスワード：ハッシュ化された状態で保存（平文では保存しない）
            $table->string('password');

            // Remember Token：「ログイン状態を保持する」チェックボックス用
            // 100文字のランダム文字列でセッションを管理
            $table->rememberToken();

            // 作成日時と更新日時のカラムを自動作成
            $table->timestamps();
        });
    }

    /**
     * マイグレーションをロールバックしてusersテーブルを削除する処理
     * 
     * このメソッドは、php artisan migrate:rollbackコマンドで実行されます。
     * up()メソッドで行った操作を元に戻すための処理です。
     * 
     * 注意事項：
     * - テーブルを削除すると、全ユーザーアカウントが失われます
     * - 管理者アカウントも削除されるため、ログインできなくなります
     * - 他のテーブルがこのテーブルを参照している場合、外部キーエラーが発生する可能性
     * - 本番環境でのロールバックは非常に危険です
     * 
     * 使用ケース：
     * - マイグレーションのテスト時
     * - 開発環境でのデータベースリセット時
     * - テーブル構造の大幅変更時
     * 
     * @return void
     */
    public function down()
    {
        // usersテーブルが存在する場合のみ削除する
        // この操作は全ユーザーデータを失うため、最新の注意が必要
        Schema::dropIfExists('users');
    }
}
