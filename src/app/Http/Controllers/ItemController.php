<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Comment;
use App\Models\Favorite;
use Intervention\Image\Facades\Image;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::orderBy('id', 'asc')->get();

        $user = Auth::user();
        $favorites =collect();
        if ($user && $user->profile) {
            $favoriteItemIds = Favorite::where('profile_id', $user->profile->id)->pluck('item_id');
            $favorites = Item::whereIn('id', $favoriteItemIds)->get();
        }

        return view('index', compact('items', 'favorites'));
    }

    public function sell()
    {
        $categories = Category::all();

        return view('sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $item_data = $request->only(['condition', 'name', 'brand', 'description', 'price']);

        $item_data['profile_id'] = auth()->user()->profile->id;

        if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $img = Image::make($image->getRealPath());

        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save(storage_path('app/public/img/' . $filename), 75);

        $item_data['image'] = 'storage/img/' . $filename;
        }

        $item = Item::create($item_data);

        if ($request->has('category_id'))
        {
            $item->categories()->sync($request->input('category_id'));
        }

        return redirect('/');
    }

    public function item($item_id)
    {
        $item = Item::with(['categories', 'comments.profile'])->findOrFail($item_id);

        return view('item', compact('item'));
    }

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