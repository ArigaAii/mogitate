<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'   => 'required|string',
            'price'  => 'required|integer|min:0|max:10000',
            'image'  => 'required|mimes:png,jpeg',
            'season' => 'required|array',
            'season.*' => 'integer|in:1,2,3,4',
            'detail' => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',

            'price.required' => '値段を入力してください',
            'price.integer'  => '数値で入力してください',
            'price.between'  => '0〜10000円以内で入力してください',

            'image.required' => '商品画像を選択してください',
            'image.mimes'    => '.png または .jpeg 形式でアップロードしてください',

            'season.required' => '季節を選択してください',

            'detail.required' => '商品説明を入力してください',
            'detail.max'      => '120文字以内で入力してください',
        ];
    }
}
