<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressEditRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user_data = $request->only(['name', 'email', 'password']);
        $user_data['password'] = Hash::make($user_data['password']);

        $user = User::create($user_data);
        Auth::login($user);

        return redirect('/mypage/profile');
    }

    public function edit_profile()
    {
        return view('.mypage.profile');
    }

    public function create_profile(Request $request)
    {
         // AddressRequest のバリデーションを実行
        $addressRequest = new AddressRequest();
        $addressRequest->setContainer(app())->setRedirector(app('redirect'));
        $addressRequest->merge($request->all());
        $addressRequest->validateResolved();

        // ProfileRequest のバリデーションを実行
        $profileRequest = new ProfileRequest();
        $profileRequest->setContainer(app())->setRedirector(app('redirect'));
        $addressRequest->merge($request->all());
        $profileRequest->validateResolved();

        //ユーザー情報のupdate(usersテーブル)
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();

        $profile_data = $request->only(['name', 'postal_code', 'address', 'building']);
        $profile_data['user_id'] = $user->id;

        // 画像ファイルの処理
        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('profile_images', 'public');
        $profile_data['image'] = $path; // DBに保存する用のパス
        }

        //プロフィールの保存(新規 or 更新)
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profile_data
        );

        return redirect('/');
    }

    public function address($item_id)
    {
        $user_id = auth()->id();

        $profile = Profile::where('user_id', $user_id)
        ->select('id', 'postal_code', 'address', 'building')
        ->firstOrFail();

        return view('purchase.address', compact('profile', 'item_id'));
    }

    public function update(AddressEditRequest $request)
    {
        $address = $request->only(['postal_code', 'address', 'building']);
        $profile = Profile::find($request->id);
        $profile->update($address);

        $item_id = $request->input('item_id');

        return redirect('/purchase/' . $item_id);
    }

    public function mypage()
    {
        $profile = Profile::where('user_id', auth()->id())->first();

        return view('mypage', compact('profile'));
    }
}