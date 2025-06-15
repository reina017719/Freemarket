<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|mimes:jpeg,png',
            'name' => 'required',
            'category_id' => 'required',
            'condition_id' => 'required',
            'description' => 'required|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '画像を選択してください',
            'image.mimes' => '「png」または「jpeg」形式でアップロードしてください',
            'name.required' => '商品名を入力してください',
            'category_id.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '状態を選択してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '255文字以下で入力してください',
            'price.required' => '金額を入力してください',
            'price.numeric' => '数字で入力してください',
            'price.min' => '0円以上で入力してください',
        ];
    }
}
