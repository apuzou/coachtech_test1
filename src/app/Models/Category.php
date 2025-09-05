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
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
