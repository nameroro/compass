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

    public function getValidatorInstance()
    {
        $this->input('old_year');
        $this->input('old_month');
        $this->input('old_day');

        $datetime = implode('-', $this->only(['old_year', 'old_month', 'old_day']));

        // dd($datetime);
        $this->merge([
            'datetime' => $datetime,
        ]);

        return parent::getValidatorInstance();
    }

    public function rules()
    {
        return [
            'over_name' => 'required|max:10',
            'under_name' => 'required|max:10',
            'over_name_kana' => 'required|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'mail_address' => 'required|max:100|unique:users,mail_address|email',
            'sex' => 'required|integer|between:1,3',
            'old_year' => 'required_with:old_month,old_day',
            'old_month' => 'required_with:old_year,old_day',
            'old_day' => 'required_with:old_month,old_year',
            'datetime' => 'required|date|after:2000-1-1|before:today',
            'role' => 'required|integer|between:1,4',
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
            'sex.required' => '※性別は「男性」「女性」「その他」から選択して下さい',
            'sex.between' => '※性別は「男性」「女性」「その他」から選択して下さい',
            'old_year.required_with' => '※生年月日が未入力です',
            // 'old_year.after' => '※2000年1月1日から今日までの日付を入力して下さい',
            // 'old_year.before' => '※2000年1月1日から今日までの日付を入力して下さい',
            'old_month.required_with' => '※生年月日が未入力です',
            'old_day.required_with' => '※生年月日が未入力です',
            'datetime.required' => '※生年月日が未入力です',
            'datetime.date' => '※正しい日付を入力して下さい',
            'datetime.after' => '※2000年1月1日から今日までの日付を入力して下さい',
            'datetime.before' => '※2000年1月1日から今日までの日付を入力して下さい',
            'role.required' => '※役職は「講師(国語)」「講師(数学)」「教師(英語)」「生徒」から選択して下さい',
            'role.between' => '※役職は「講師(国語)」「講師(数学)」「教師(英語)」「生徒」から選択して下さい',
            'password.required' => '※パスワードを入力して下さい',
            'password.alpha_num' => '※パスワードは英数字のみで入力して下さい',
            'password.min' => '※パスワードは8文字以上、30文字以内で入力して下さい',
            'password.max' => '※パスワードは8文字以上、30文字以内で入力して下さい',
            'password_confirmation.required' => '※確認パスワードを入力して下さい',
            'password.confirmed' => '※パスワードが一致していません',
            'password_confirmation.alpha_num' => '※パスワードは英数字のみで入力して下さい',
            'password_confirmation.min' => '※パスワードは8文字以上、30文字以内で入力して下さい',
            'password_confirmation.max' => '※パスワードは8文字以上、30文字以内で入力して下さい',
        ];
    }
}
