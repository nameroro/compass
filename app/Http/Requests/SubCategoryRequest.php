<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => 'required|max:100|string|unique:sub_categories,sub_category',
        ];
    }

    public function messages(){
        return [
            'main_category_id.exists' => 'このメインカテゴリーは存在していません',
            'sub_category_name.required' => 'サブカテゴリーを入力して下さい',
            'sub_category_name.max' => 'サブカテゴリーは100文字以内で入力して下さい',
            'sub_category_name.unique' => 'このサブカテゴリーは既に存在しています',
        ];
    }
}
