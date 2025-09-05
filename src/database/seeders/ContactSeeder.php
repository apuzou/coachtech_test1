<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

/**
 * お問い合わせのテストデータを投入するシーダークラス
 *
 * このクラスは、管理画面でのテストやデモンストレーション用に、
 * 大量のお問い合わせデータを自動生成してデータベースに投入します。
 *
 * 主な機能：
 * - ContactFactoryを使用したリアルなテストデータの一括生成
 * - ページネーションや検索機能のテストに十分なデータ量を提供
 * - 日本の実情に合わせたリアルなデータ（住所、電話番号等）
 */
class ContactSeeder extends Seeder
{
    /**
     * お問い合わせのテストデータをデータベースに投入する処理
     *
     * ContactFactoryを使用して、リアルなテストデータを一括生成します。
     * 各データはランダムに生成され、既存のカテゴリーと関連付けられます。
     *
     * 生成されるデータの内容：
     * - ランダムな日本人の名前（姓・名）
     * - ランダムな性別（1:男性, 2:女性, 3:その他）
     * - ユニークなメールアドレス
     * - 日本の電話番号形式（xxx-xxxx-xxxx）
     * - 47都道府県からランダム選択した現実的な住所
     * - オプショナルな建物名（70%の確率で生成）
     * - ランダムなお問い合わせ内容（段落形式）
     * - 既存カテゴリーからランダム選択
     *
     * 前提条件：
     * CategorySeederが先に実行されていることが必要です。
     * （カテゴリーデータが存在しないとエラーになります）
     *
     * @return void
     */
    public function run()
    {
        Contact::factory(35)->create();
    }
}
