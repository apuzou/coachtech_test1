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
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tell',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function newFactory()
    {
        return ContactFactory::new();
    }
}
