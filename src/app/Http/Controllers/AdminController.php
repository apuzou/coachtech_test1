<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
  /**
   * 管理画面のインデックスページ
   */
  public function index(Request $request): View
  {
    $query = Contact::with('category');

    // 検索・フィルター条件を適用
    $this->applyFilters($query, $request);

    $contacts = $query->orderBy('created_at', 'desc')->paginate(7);
    $categories = Category::all();

    return view('admin.admin', compact('contacts', 'categories'));
  }

  /**
   * お問い合わせ詳細表示
   */
  public function show(Contact $contact): View
  {
    $contact->load('category');
    return view('admin.show', compact('contact'));
  }

  /**
   * 検索・フィルター条件を適用
   */
  private function applyFilters($query, Request $request): void
  {
    // 検索条件
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('first_name', 'LIKE', "%{$search}%")
          ->orWhere('last_name', 'LIKE', "%{$search}%")
          ->orWhere('email', 'LIKE', "%{$search}%");
      });
    }

    // フィルター条件
    if ($request->filled('gender')) {
      $query->where('gender', $request->gender);
    }

    if ($request->filled('category_id')) {
      $query->where('category_id', $request->category_id);
    }

    if ($request->filled('date')) {
      $query->whereDate('created_at', $request->date);
    }
  }

  /**
   * 性別の表示テキストを取得
   */
  public static function getGenderText(int $gender): string
  {
    return match ($gender) {
      1 => '男性',
      2 => '女性',
      3 => 'その他',
      default => '未選択',
    };
  }
}
