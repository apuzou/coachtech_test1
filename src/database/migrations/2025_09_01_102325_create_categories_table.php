<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * お問い合わせカテゴリーテーブルを作成するマイグレーション
 * 
 * このマイグレーションは、お問い合わせの種類（カテゴリー）を管理する
 * categoriesテーブルをデータベースに作成します。
 * 
 * テーブルの目的：
 * - お問い合わせフォームで選択できる種類のマスターデータを保存
 * - contactsテーブルとのリレーションで、お問い合わせを分類
 * - 管理画面でのフィルタリング機能で使用
 * 
 * テーブル構造：
 * - id: 主キー（自動連番）
 * - content: カテゴリー名（例：「商品の交換について」）
 * - created_at/updated_at: 作成日時・更新日時
 * 
 * ファイル名の意味：
 * 2025_09_01_102325 = 2025年09月01日 10時23分25秒に作成されたマイグレーション
 * このタイムスタンプにより、Laravelはマイグレーションの実行順序を決定します。
 */
class CreateCategoriesTable extends Migration
{
    /**
     * マイグレーションを実行してcategoriesテーブルを作成する処理
     * 
     * このメソッドは、php artisan migrateコマンドで実行されます。
     * Schema::create()でテーブルを作成し、Blueprintでカラムを定義します。
     * 
     * カラムの詳細説明：
     * - id(): 主キー、自動連番、UNSIGNED BIGINT、AUTO_INCREMENT
     * - string('content'): カテゴリー名、VARCHAR(255)、NOT NULL
     * - timestamps(): created_atとupdated_atカラムを自動作成、TIMESTAMP型
     * 
     * データ例：
     * | id | content                    | created_at          | updated_at          |
     * |----|----------------------------|---------------------|---------------------|
     * | 1  | 商品のお届けについて         | 2025-01-01 10:00:00 | 2025-01-01 10:00:00 |
     * | 2  | 商品の交換について           | 2025-01-01 10:01:00 | 2025-01-01 10:01:00 |
     * 
     * @return void
     */
    public function up()
    {
        // 'categories'という名前のテーブルを作成
        Schema::create('categories', function (Blueprint $table) {
            // 主キー：自動連番のIDカラムを作成
            $table->id();

            // カテゴリー名：文字列型（VARCHAR(255)）、必須項目
            // 例：「商品の交換について」「配送について」等
            $table->string('content');

            // 作成日時と更新日時のカラムを自動作成
            // created_atとupdated_atの2つのカラムが作成される
            $table->timestamps();
        });
    }

    /**
     * マイグレーションをロールバックしてcategoriesテーブルを削除する処理
     * 
     * このメソッドは、php artisan migrate:rollbackコマンドで実行されます。
     * up()メソッドで行った操作を元に戻すための処理です。
     * 
     * 注意事項：
     * - テーブルを削除すると、保存されていた全データが失われます
     * - 他のテーブルがこのテーブルを参照している場合、外部キーエラーが発生する可能性
     * - 本番環境でのロールバックは最新の注意が必要
     * 
     * 使用ケース：
     * - マイグレーションのテスト時
     * - テーブル構造の変更が必要になった時
     * - 開発環境でのデータベースリセット時
     * 
     * @return void
     */
    public function down()
    {
        // categoriesテーブルが存在する場合のみ削除する
        // dropIfExists()はテーブルが存在しない場合でもエラーにならない
        Schema::dropIfExists('categories');
    }
}
