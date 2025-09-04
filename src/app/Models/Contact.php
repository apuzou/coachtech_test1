<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ContactFactory;

/**
 * お問い合わせデータを管理するモデルクラス
 * 
 * このクラスは、データベースのcontactsテーブルと連携し、
 * お問い合わせ情報の保存・取得・更新・削除を行います。
 * 
 * 主な機能：
 * - お問い合わせデータの管理
 * - カテゴリーとのリレーション（関連付け）
 * - テストデータ生成用のファクトリー機能
 */
class Contact extends Model
{
    use HasFactory;  // ファクトリー機能を使用するためのトレイト

    /**
     * 一括代入可能な属性を定義
     * 
     * セキュリティのため、通常はすべての属性が一括代入から保護されています。
     * ここに記載された属性のみ、create()やupdate()で一括設定が可能になります。
     * 
     * 各属性の説明：
     * - category_id: お問い合わせの種類ID（categoriesテーブルとの外部キー）
     * - first_name: 名前（名）
     * - last_name: 名前（姓）
     * - gender: 性別（1:男性, 2:女性, 3:その他）
     * - email: メールアドレス
     * - tell: 電話番号
     * - address: 住所
     * - building: 建物名
     * - detail: お問い合わせ内容
     */
    protected $fillable = [
        'category_id',  // お問い合わせの種類ID
        'first_name',   // 名前（名）
        'last_name',    // 名前（姓）
        'gender',       // 性別
        'email',        // メールアドレス
        'tell',         // 電話番号
        'address',      // 住所
        'building',     // 建物名
        'detail',       // お問い合わせ内容
    ];

    /**
     * カテゴリーとのリレーション（関連付け）を定義
     * 
     * このメソッドにより、お問い合わせデータから関連するカテゴリー情報を取得できます。
     * 
     * リレーションの種類：belongsTo（所属する）
     * - 1つのお問い合わせは1つのカテゴリーに所属する
     * - 外部キー：category_id
     * 
     * 使用例：
     * $contact = Contact::find(1);
     * $categoryName = $contact->category->content;  // カテゴリー名を取得
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * このモデル用のファクトリーインスタンスを作成
     * 
     * ファクトリーは、テストデータやダミーデータを簡単に生成するための機能です。
     * ContactFactoryクラスで定義されたルールに従って、
     * 自動的にお問い合わせデータを生成できます。
     * 
     * 使用例：
     * Contact::factory()->create();        // 1件のテストデータを作成
     * Contact::factory()->count(10)->create(); // 10件のテストデータを作成
     * 
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ContactFactory::new();
    }
}
