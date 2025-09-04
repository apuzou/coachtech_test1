<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * お問い合わせの種類（カテゴリー）を管理するモデルクラス
 * 
 * このクラスは、データベースのcategoriesテーブルと連携し、
 * お問い合わせの種類（例：商品の交換について、配送についてなど）を管理します。
 * 
 * 主な機能：
 * - カテゴリー情報の管理
 * - お問い合わせとのリレーション（関連付け）
 */
class Category extends Model
{
    use HasFactory;  // ファクトリー機能を使用するためのトレイト

    /**
     * 一括代入可能な属性を定義
     * 
     * セキュリティのため、通常はすべての属性が一括代入から保護されています。
     * ここに記載された属性のみ、create()やupdate()で一括設定が可能になります。
     * 
     * 各属性の説明：
     * - content: カテゴリー名（例：「商品の交換について」「配送について」など）
     */
    protected $fillable = [
        'content',  // カテゴリー名
    ];

    /**
     * お問い合わせとのリレーション（関連付け）を定義
     * 
     * このメソッドにより、カテゴリーから関連するすべてのお問い合わせを取得できます。
     * 
     * リレーションの種類：hasMany（複数所有）
     * - 1つのカテゴリーは複数のお問い合わせを持つことができる
     * - 外部キー：contactsテーブルのcategory_id
     * 
     * 使用例：
     * $category = Category::find(1);
     * $contacts = $category->contacts;  // このカテゴリーのすべてのお問い合わせを取得
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
