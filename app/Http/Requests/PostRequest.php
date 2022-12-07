<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'over_name' => 'required|max:10',
            'under_name' => 'required|max:10',
            'over_name_kana' => 'required|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'mail_address' => 'required|max:100|unique:users,mail_address|email',
            'sex' => 'required',
            'old_year' => 'required_with:old_month,old_day',
            'old_month' => 'required_with:old_year,old_day',
            'old_day' => 'required_with:old_month,old_year',
            'role' => 'required',
            'password' => 'required|alpha_num|min:8|max:30|confirmed',
            'password_confirmation' => 'required|alpha_num|min:8|max:30',
        ];
    }

    public function messages()
    {
        return [
            'over_name.max' => '※性は10文字以内で入力して下さい',
            'under_name.max' => '※名は10文字以内で入力して下さい',
            'over_name_kana.regex' => '※セイはカタカナで入力して下さい',
            'over_name_kana.max' => '※セイは30文字以内で入力して下さい',
            'under_name_kana.regex' => '※メイはカタカナで入力して下さい',
            'under_name_kana.max' => '※メイは30文字以内で入力して下さい',
            'mail_address.email' => '※メール形式で入力して下さい',
            'mail_address.unique' => '※このメールアドレスは既に使用されています',
            'old_year.required_with' => '※生年月日が未入力です',
            'old_month.required_with' => '※生年月日が未入力です',
            'old_day.required_with' => '※生年月日が未入力です',
            'password.required' => 'パスワードを入力して下さい',
            'password.alpha_num' => 'パスワードは英数字のみで入力して下さい',
            'password.min' => 'パスワードは8文字以上、30文字以内で入力して下さい',
            'password.max' => 'パスワードは8文字以上、30文字以内で入力して下さい',
            'password.confirmed' => 'パスワードが一致していません',
            'password_confirmation.required' => '確認パスワードを入力して下さい',
        ];
    }
}
