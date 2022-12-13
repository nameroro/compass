<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment' => 'required|max:2500|string',
        ];
    }

    public function messages(){
        return [
            'comment.required' => 'コメントを入力して下さい',
            'comment.max' => '内容は2500文字以内入力して下さい',
            'comment.string' => '正しい文字列で入力して下さい',
        ];
    }

}
