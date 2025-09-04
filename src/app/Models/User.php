<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * ユーザー情報を管理するモデルクラス
 * 
 * このクラスは、データベースのusersテーブルと連携し、
 * ユーザーの登録・ログイン・認証などの機能を提供します。
 * 
 * 主な機能：
 * - ユーザーアカウントの管理
 * - ログイン・ログアウト機能
 * - APIトークン管理（Sanctum）
 * - 通知機能
 */
class User extends Authenticatable
{
    // 使用するトレイトを定義
    use HasApiTokens,  // APIトークン機能を提供
        HasFactory,    // ファクトリー機能を提供
        Notifiable;    // 通知機能を提供

    /**
     * 一括代入可能な属性を定義
     * 
     * セキュリティのため、通常はすべての属性が一括代入から保護されています。
     * ここに記載された属性のみ、create()やupdate()で一括設定が可能になります。
     * 
     * 各属性の説明：
     * - name: ユーザー名
     * - email: メールアドレス（ログインIDとしても使用）
     * - password: パスワード（ハッシュ化されて保存）
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'name',      // ユーザー名
        'email',     // メールアドレス
        'password',  // パスワード
    ];

    /**
     * JSONシリアライゼーション時に非表示にする属性を定義
     * 
     * APIレスポンスやJSON出力時に、セキュリティ上重要な情報を
     * 間違って漏洩しないように、ここに指定した属性は自動的に除外されます。
     * 
     * 各属性の説明：
     * - password: パスワードハッシュ（絶対に外部に漏らしてはいけない）
     * - remember_token: ログイン状態を維持するためのトークン
     * 
     * @var array<int, string>
     */
    protected $hidden = [
        'password',        // パスワードハッシュ
        'remember_token',  // ログイン維持用トークン
    ];

    /**
     * 属性のデータ型を自動変換するためのキャスト設定
     * 
     * データベースから取得した値を、指定したデータ型に自動変換します。
     * これにより、アプリケーション側で適切なデータ型で扱うことができます。
     * 
     * 各属性の説明：
     * - email_verified_at: メール認証日時をCarbonインスタンス（日時操作ライブラリ）に変換
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',  // メール認証日時をCarbonインスタンスに変換
    ];
}
