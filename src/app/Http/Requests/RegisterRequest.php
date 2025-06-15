<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.unique' => 'このメールアドレスはすでに登録されています',

            'password.required' => 'パスワードを入力してください',
            'password.min' => '8文字以上で入力してください',
            'password.confirmed' => '確認用パスワードと一致させてください',

            'password_confirmation.required' => '確認用パスワードを入力してください',
            'password_confirmation.min' => '8文字以上で入力してください',
        ];
    }
}
