<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * このマイグレーションは、ユーザーからのお問い合わせデータを保存する
 * contactsテーブルをデータベースに作成します。
 *
 * テーブルの目的：
 * - お問い合わせフォームから送信されたデータを保存
 * - 管理者がお問い合わせ内容を閲覧・管理できるようにする
 * - カテゴリー別の分類や検索機能を提供
 *
 * リレーション：
 * - categoriesテーブルとの外部キー関係（多対1）
 * - 1つのお問い合わせは1つのカテゴリーに属する
 */

class CreateContactsTable extends Migration
{
    /**
     * 外部キー制約：
     * category_idはcategoriesテーブルのidカラムを参照し、
     * カテゴリーが削除されると関連するお問い合わせも影響を受けます。
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // 外部キー：categoriesテーブルのidカラムを参照する外部キー
            // constrained('categories')で外部キー制約を設定
            $table->foreignId('category_id')->constrained('categories');

            $table->string('first_name');
            $table->string('last_name');

            // 性別：数値で管理（1=男性, 2=女性, 3=その他）
            $table->tinyInteger('gender')->comment('1:男性 2:女性 3:その他');

            $table->string('email');
            $table->string('tell');

            $table->string('address');
            $table->string('building')->nullable();

            $table->text('detail');

            $table->timestamps();
        });
    }

    /**
     * 注意事項：
     * - 外部キー制約があるため、categoriesテーブルより先に削除する必要があります
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
