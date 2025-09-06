<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

/**
 * お問い合わせ機能を管理するコントローラー
 * このクラスは、お問い合わせフォームの表示から送信までの一連の処理を担当します
 */
class ContactController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }

    /**
     * お問い合わせ確認画面を表示する処理
     *
     * 流れ：
     * 1. フォームから送信されたデータをバリデーション（ContactRequestで自動実行）
     * 2. 送信データを整理してお問い合わせデータを準備
     * 3. 選択されたカテゴリー情報をデータベースから取得
     * 4. 確認画面にデータを渡して表示
     */
    public function confirm(ContactRequest $request): View
    {
        // フォームデータを整理してお問い合わせデータを作成
        $contactData = $this->prepareContactData($request);

        // 選択されたカテゴリーIDから、カテゴリー情報を取得
        $category = Category::find($request->category_id);

        // 確認画面（confirm.blade.php）にデータを渡して表示
        return view('contact.confirm', compact('contactData', 'category'));
    }

    /**
     * 修正ボタンがクリックされた際の処理
     *
     * 流れ：
     * 1. 確認画面で「修正」ボタンが押された時に実行される
     * 2. ユーザーが入力したデータをセッションに一時保存
     * 3. 入力フォーム画面に戻り、保存したデータを再表示
     */
    public function edit(Request $request): View
    {
        // 前回入力した値をセッション（一時的な記憶領域）に保存
        $request->session()->flash('old_input', [
            'category_id' => $request->category_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'phone3' => $request->phone3,
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ]);

        $categories = Category::all();
        return view('index', compact('categories'));
    }

    /**
     * お問い合わせをデータベースに保存する処理
     *
     * 流れ：
     * 1. 確認画面で「送信」ボタンが押された時に実行される
     * 2. フォームデータを整理してお問い合わせデータを作成
     * 3. データベースに新しいお問い合わせレコードを保存
     * 4. 送信完了画面にリダイレクト
     */
    public function store(Request $request): RedirectResponse
    {
        // 確認画面からの送信時は、tellが既に結合された状態で送られてくる
        $contactData = [
            'category_id' => $request->category_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tell' => $request->tell, // 確認画面から直接送られてくる結合済みの電話番号
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ];

        // データベースのcontactsテーブルに新しいレコードを作成・保存
        Contact::create($contactData);

        // 送信完了画面（thanks）にリダイレクト
        return redirect()->route('contact.thanks');
    }

    /**
     * サンクスページ（送信完了画面）を表示する処理
     */
    public function thanks(): View
    {
        return view('contact.thanks');
    }

    /**
     * フォームから送信されたデータを整理してお問い合わせデータを準備する処理
     *
     * 目的：
     * - フォームの入力項目をデータベース保存用の形式に変換
     * - 電話番号を3つの項目から1つの文字列に結合
     * - データの整合性を保つ
     */
    private function prepareContactData(Request $request): array
    {
        return [
            'category_id' => $request->category_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tell' => $this->formatPhoneNumber($request),
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ];
    }

    /**
     * 電話番号を3つの入力項目から1つの文字列にフォーマットする処理
     *
     * 例：
     * - phone1: "080", phone2: "1234", phone3: "5678"
     * - 結果: "080-1234-5678"
     */
    private function formatPhoneNumber(Request $request): string
    {
        // 3つの電話番号項目を「-」で結合して1つの文字列にする
        return implode('-', [$request->phone1, $request->phone2, $request->phone3]);
    }

    /**
     * 性別の数値を日本語テキストに変換する処理
     *
     * データベースには性別を数値で保存しているが、
     * 画面表示時は日本語で表示したいため変換が必要
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
