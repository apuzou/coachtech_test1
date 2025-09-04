<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * このマイグレーションは、お問い合わせの種類（カテゴリー）を管理する
 * categoriesテーブルをデータベースに作成します。
 *
 * テーブルの目的：
 * - お問い合わせフォームで選択できる種類のマスターデータを保存
 * - contactsテーブルとのリレーションで、お問い合わせを分類
 * - 管理画面でのフィルタリング機能で使用
 */

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('content');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
