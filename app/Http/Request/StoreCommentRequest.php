<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
                'text' => 'required|string|min:2|max:500',
            ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Будь ласка, введіть зміст коментаря.',
            'content.string' => 'Зміст коментаря має бути рядком.',
            'content.min' => 'Содержание комментария не может быть меньше 2 символов',
            'content.max' => 'Зміст коментаря не може перевищувати 500 символів.',
        ];
    }
}
