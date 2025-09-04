<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * お問い合わせテーブルを作成するマイグレーション
 * 
 * このマイグレーションは、ユーザーからのお問い合わせデータを保存する
 * contactsテーブルをデータベースに作成します。
 * 
 * テーブルの目的：
 * - お問い合わせフォームから送信されたデータを保存
 * - 管理者がお問い合わせ内容を閲覧・管理できるようにする
 * - カテゴリー別の分類や検索機能を提供
 * 
 * テーブル構造：
 * - 個人情報：名前、性別、メールアドレス、電話番号、住所
 * - お問い合わせ情報：カテゴリー、内容
 * - システム情報：作成日時、更新日時
 * 
 * リレーション：
 * - categoriesテーブルとの外部キー関係（多対1）
 * - 1つのお問い合わせは1つのカテゴリーに属する
 * 
 * ファイル名の意味：
 * 2025_09_01_102330 = 2025年09月01日 10時23分30秒に作成されたマイグレーション
 * categoriesテーブルの作成後に実行されるようにタイムスタンプが設定されています。
 */
class CreateContactsTable extends Migration
{
    /**
     * マイグレーションを実行してcontactsテーブルを作成する処理
     * 
     * このメソッドは、php artisan migrateコマンドで実行されます。
     * Schema::create()でテーブルを作成し、Blueprintで各カラムを定義します。
     * 
     * カラムの詳細説明：
     * - id(): 主キー、自動連番、UNSIGNED BIGINT、AUTO_INCREMENT
     * - foreignId('category_id'): 外部キー、categoriesテーブルへの参照
     * - string('first_name'): 名前（名）、VARCHAR(255)、NOT NULL
     * - string('last_name'): 名前（姓）、VARCHAR(255)、NOT NULL
     * - tinyInteger('gender'): 性別、TINYINT、NOT NULL（1:男性, 2:女性, 3:その他）
     * - string('email'): メールアドレス、VARCHAR(255)、NOT NULL
     * - string('tell'): 電話番号、VARCHAR(255)、NOT NULL
     * - string('address'): 住所、VARCHAR(255)、NOT NULL
     * - string('building')->nullable(): 建物名、VARCHAR(255)、NULL可
     * - text('detail'): お問い合わせ内容、TEXT、NOT NULL
     * - timestamps(): created_atとupdated_atカラムを自動作成
     * 
     * 外部キー制約：
     * category_idはcategoriesテーブルのidカラムを参照し、
     * カテゴリーが削除されると関連するお問い合わせも影響を受けます。
     * 
     * @return void
     */
    public function up()
    {
        // 'contacts'という名前のテーブルを作成
        Schema::create('contacts', function (Blueprint $table) {
            // 主キー：自動連番のIDカラムを作成
            $table->id();

            // 外部キー：categoriesテーブルのidカラムを参照する外部キー
            // constrained('categories')で外部キー制約を設定
            $table->foreignId('category_id')->constrained('categories');

            // 個人情報関連のカラム
            $table->string('first_name');    // 名前（名）
            $table->string('last_name');     // 名前（姓）

            // 性別：数値で管理（1=男性, 2=女性, 3=その他）
            // comment()でデータベースレベルでのコメントを追加
            $table->tinyInteger('gender')->comment('1:男性 2:女性 3:その他');

            // 連絡先情報
            $table->string('email');         // メールアドレス
            $table->string('tell');          // 電話番号（ハイフン区切りで保存）

            // 住所情報
            $table->string('address');       // 住所（都道府県から番地まで）
            $table->string('building')->nullable();  // 建物名（オプショナル、NULL可）

            // お問い合わせ内容：長いテキストを保存できるTEXT型
            $table->text('detail');

            // 作成日時と更新日時のカラムを自動作成
            $table->timestamps();
        });
    }

    /**
     * マイグレーションをロールバックしてcontactsテーブルを削除する処理
     * 
     * このメソッドは、php artisan migrate:rollbackコマンドで実行されます。
     * up()メソッドで行った操作を元に戻すための処理です。
     * 
     * 注意事項：
     * - テーブルを削除すると、保存されていた全お問い合わせデータが失われます
     * - 外部キー制約があるため、categoriesテーブルより先に削除する必要があります
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
        // contactsテーブルが存在する場合のみ削除する
        // 外部キー制約があるため、categoriesテーブルより先に削除される
        Schema::dropIfExists('contacts');
    }
}
