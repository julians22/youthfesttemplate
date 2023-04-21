<?php

namespace App\Http\Requests\Frontend\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => ['required', 'max:225'],
            'url' => ['required', 'url'],
            'type' => ['required', 'in:tiktok,instagram,youtube'],
            'thumbnail' => ['sometimes', 'mimes:png,jpg,jpeg', 'max:10000']
        ];
    }
}
