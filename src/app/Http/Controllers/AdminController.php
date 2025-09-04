<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Contact;
use App\Models\Category;

/**
 * 管理画面機能を管理するコントローラー
 * このクラスは、お問い合わせデータの一覧表示、検索、削除などの管理者向け機能を担当します
 */
class AdminController extends Controller
{
  /**
   * 管理画面のメインページ（お問い合わせ一覧）を表示する処理
   * 
   * 流れ：
   * 1. データベースからお問い合わせデータを取得（カテゴリー情報も一緒に取得）
   * 2. 検索・フィルター条件があれば適用
   * 3. データを作成日時の新しい順で並び替え、7件ずつページ分割
   * 4. カテゴリー一覧も取得（検索フィルター用）
   * 5. 管理画面にデータを渡して表示
   */
  public function index(Request $request): View
  {
    // お問い合わせデータをカテゴリー情報と一緒に取得するクエリを準備
    // with('category')により、N+1問題を防ぎ効率的にデータを取得
    $query = Contact::with('category');

    // 検索・フィルター条件を適用（名前、性別、カテゴリー、日付での絞り込み）
    $this->applyFilters($query, $request);

    // 作成日時の新しい順で並び替え、1ページあたり7件でページ分割
    $contacts = $query->orderBy('created_at', 'desc')->paginate(7);

    // 検索フィルター用にカテゴリー一覧を取得
    $categories = Category::all();

    // 管理画面（admin.blade.php）にデータを渡して表示
    return view('admin.admin', compact('contacts', 'categories'));
  }


  /**
   * お問い合わせを削除する処理
   * 
   * 流れ：
   * 1. モーダル内の削除ボタンがクリックされた時に実行される
   * 2. 指定されたお問い合わせをデータベースから削除
   * 3. 削除成功/失敗のメッセージと共に管理画面にリダイレクト
   */
  public function destroy(Contact $contact)
  {
    try {
      // データベースから該当のお問い合わせレコードを削除
      $contact->delete();

      // 削除成功メッセージと共に管理画面にリダイレクト
      return redirect()->route('admin.index')->with('success', 'お問い合わせを削除しました。');
    } catch (\Exception $e) {
      // エラーが発生した場合はエラーメッセージと共にリダイレクト
      return redirect()->route('admin.index')->with('error', 'エラーが発生しました。');
    }
  }

  /**
   * 検索・フィルター条件をデータベースクエリに適用する処理
   * 
   * 対応する検索条件：
   * - 名前検索：姓、名、メールアドレスでの部分一致検索
   * - 性別フィルター：男性、女性、その他での絞り込み
   * - カテゴリーフィルター：お問い合わせの種類での絞り込み
   * - 日付フィルター：特定の日付で作成されたお問い合わせの絞り込み
   */
  private function applyFilters($query, Request $request): void
  {
    // 名前・メールアドレス検索条件
    // 検索ボックスに入力があった場合のみ実行
    if ($request->filled('search')) {
      $search = $request->search;
      // 姓、名、メールアドレスのいずれかに検索語が含まれるレコードを取得
      $query->where(function ($q) use ($search) {
        $q->where('first_name', 'LIKE', "%{$search}%")     // 名での部分一致検索
          ->orWhere('last_name', 'LIKE', "%{$search}%")    // 姓での部分一致検索
          ->orWhere('email', 'LIKE', "%{$search}%");       // メールアドレスでの部分一致検索
      });
    }

    // 性別フィルター条件
    // 性別が選択されている場合のみ実行
    if ($request->filled('gender')) {
      $query->where('gender', $request->gender);
    }

    // カテゴリーフィルター条件
    // お問い合わせの種類が選択されている場合のみ実行
    if ($request->filled('category_id')) {
      $query->where('category_id', $request->category_id);
    }

    // 日付フィルター条件
    // 日付が選択されている場合のみ実行
    if ($request->filled('date')) {
      // 指定された日付に作成されたお問い合わせのみを取得
      $query->whereDate('created_at', $request->date);
    }
  }

  /**
   * 性別の数値を日本語テキストに変換する処理
   * 
   * データベースには性別を数値で保存しているが、
   * 管理画面では日本語で表示したいため変換が必要
   * 
   * 変換ルール：
   * - 1 → "男性"
   * - 2 → "女性" 
   * - 3 → "その他"
   * - それ以外 → "未選択"
   */
  public static function getGenderText(int $gender): string
  {
    // match文を使って数値を対応する日本語テキストに変換
    return match ($gender) {
      1 => '男性',
      2 => '女性',
      3 => 'その他',
      default => '未選択',  // 想定外の値の場合のデフォルト
    };
  }
}
