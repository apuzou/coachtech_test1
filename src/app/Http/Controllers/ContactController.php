<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * 性別の定数
     */
    private const GENDER_MALE = 1;
    private const GENDER_FEMALE = 2;
    private const GENDER_OTHER = 3;

    /**
     * お問い合わせフォームを表示
     */
    public function index(): View
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    /**
     * お問い合わせ確認画面を表示
     */
    public function confirm(Request $request): View
    {
        $contactData = $this->prepareContactData($request);
        $category = $this->getCategory($request->category_id);

        return view('contact.confirm', compact('contactData', 'category'));
    }

    /**
     * お問い合わせを保存
     */
    public function store(Request $request): RedirectResponse
    {
        $contactData = $this->prepareContactDataForStore($request);

        Contact::create($contactData);

        return redirect()->route('contact.thanks');
    }

    /**
     * サンクスページを表示
     */
    public function thanks(): View
    {
        return view('contact.thanks');
    }

    /**
     * リクエストからお問い合わせデータを準備（確認画面用）
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
     * リクエストからお問い合わせデータを準備（保存用）
     */
    private function prepareContactDataForStore(Request $request): array
    {
        return [
            'category_id' => $request->category_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tell' => $request->tell,
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ];
    }

    /**
     * 電話番号をフォーマット
     */
    private function formatPhoneNumber(Request $request): string
    {
        return $request->phone1 . '-' . $request->phone2 . '-' . $request->phone3;
    }

    /**
     * カテゴリを取得
     */
    private function getCategory(?int $categoryId): ?Category
    {
        if (!$categoryId) {
            return null;
        }

        return Category::find($categoryId);
    }

    /**
     * 性別の表示テキストを取得
     */
    public static function getGenderText(int $gender): string
    {
        return match ($gender) {
            self::GENDER_MALE => '男性',
            self::GENDER_FEMALE => '女性',
            self::GENDER_OTHER => 'その他',
            default => '未選択',
        };
    }
}
