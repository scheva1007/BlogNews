<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'title' =>' required|min:3',
            'text' => 'required|min:5',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
