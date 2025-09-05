<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

/**
 * お問い合わせカテゴリーの初期データを投入するシーダークラス
 *
 * このクラスは、お問い合わせフォームで使用される
 * カテゴリー（お問い合わせの種類）のマスターデータをデータベースに投入します。
 *
 * 投入されるカテゴリー：
 * - 商品のお届けについて
 * - 商品の交換について
 * - 商品トラブル
 * - ショップへのお問い合わせ
 * - その他
 */
class CategorySeeder extends Seeder
{
  /**
   * お問い合わせカテゴリーのマスターデータをデータベースに投入する処理
   *
   * このメソッドでは、事前に定義したカテゴリー名の配列をループで処理し、
   * 一つずつデータベースに保存します。
   *
   * 処理の流れ：
   * 1. カテゴリー名の配列を定義
   * 2. foreachループで各カテゴリーを処理
   * 3. Category::create()でデータベースに保存
   */
  public function run()
  {
    $categories = [
      '商品のお届けについて',
      '商品の交換について',
      '商品トラブル',
      'ショップへのお問い合わせ',
      'その他'
    ];

    foreach ($categories as $content) {
      Category::create([
        'content' => $content
      ]);
    }
  }
}
