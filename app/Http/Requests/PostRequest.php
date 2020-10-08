<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Post;
use App\User;

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
            'title'=>'required|max:255',
            'article'=>'required',
            'image'=>'nullable|image|max:1014|',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'請輸入標題',
            'article.required'=>'請輸入文章內容',
        ];
        
    }
}
