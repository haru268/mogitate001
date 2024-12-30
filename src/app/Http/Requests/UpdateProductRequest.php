<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    return [
        'name' => 'required|max:255',
        'price' => 'required|numeric|between:0,10000',
        'season' => 'required|array',
        'season.*' => 'exists:seasons,name',
        'description' => 'required|max:120',
        'image' => 'nullable|image|mimes:jpeg,png|max:2048',

    ];
    }


    protected function prepareForValidation()
    {
       
    }
    

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'season.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください'
        ];
    }
}
