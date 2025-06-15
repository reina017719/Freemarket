<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Comment;
use Intervention\Image\Facades\Image;

class ItemController extends Controller
{
    //トップページ（商品一覧）
    public function index(Request $request)
    {
        $items = Item::latest()->get();

        return view('index', compact('items'));
    }

    //出品ページ（フォーム表示）
    public function sell()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell', compact('categories', 'conditions'));
    }

    //出品保存処理
    public function store(ExhibitionRequest $request)
    {
        $item_data = $request->only(['name', 'brand', 'description', 'price']);

        //画像の保存＋圧縮処理
        if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        // Intervention Image で画像加工
        $img = Image::make($image->getRealPath());

        // サイズを縮小（例：最大幅800pxに縮小、縦横比保持）
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize(); // 小さい画像は拡大しない
        });

        // 75%品質で保存（jpegの場合）
        $img->save(storage_path('app/public/img/' . $filename), 75);

        // 公開パスを保存
        $item_data['image'] = 'storage/img/' . $filename;
        }

        //カテゴリーの保存
        if ($request->has('category_id'))
        {
            $item_data['category_id'] = $request->input('category_id');
        }

        //状態の保存
        if ($request->has('condition_id'))
        {
            $item_data['condition_id'] = $request->input('condition_id');
        }

        Item::create($item_data);

        return redirect('/');
    }

    //商品詳細
    public function item($item_id)
    {
        $item = Item::with(['category', 'condition', 'comments.profile'])->findOrFail($item_id);

        return view('item', compact('item'));
    }

    //購入ページ
    public function purchase($item_id)
    {
        session(['purchase_item_id' => $item_id]);
        $item = Item::select('id', 'image', 'name', 'price')->findOrFail($item_id);
        $payments = Payment::all();
        $user = auth()->user();
        $address = Profile::where('user_id', $user->id)->select('postal_code', 'address', 'building')->firstOrFail();

        return view('purchase', compact('item', 'payments', 'address', 'user'));
    }

    public function comment(Request $request)
    {
        $request->validate([
        'comment' => 'required|string|max:255',
        'item_id' => 'required|exists:items,id',
        ], [
            'comment.required' => 'コメントを入力してください。',
            'comment.max' => 'コメントは255文字以下で入力してください。',
            'item_id.required' => '商品情報が見つかりません。',
            'item_id.exists' => '指定された商品が存在しません。',
        ]);

        $profile = Profile::where('user_id', auth()->id())->firstOrFail();

        Comment::create([
            'comment' => $request->comment,
            'item_id' => $request->item_id,
            'profile_id' => $profile->id,
        ]);

        return back();
    }

    public function favorite(Item $item)
    {
        $profile = \App\Models\Profile::where('user_id', auth()->id())->firstOrFail();

        $existing = $item->favorites()->where('profile_id', $profile->id)->first();
        if ($existing) {
        $existing->delete();
        } else {
        $item->favorites()->create(['profile_id' => $profile->id]);
        }

        return back();
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $items = Item::KeywordSearch($request->keyword)->get();

        return view('index', compact('items'));
    }
}