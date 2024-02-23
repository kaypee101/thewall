<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use App\Rules\IsValueLengthValidRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    /**
     * @return array
     */
    public function store(): array
    {
        return [
            'title' => [
                'required',
                new IsValueLengthValidRule(3, 50),
                'unique:posts,title,NULL,id,deleted_at,NULL',
            ],
        ];
    }

    /**
     * @return array
     */
    public function update(): array
    {
        $id = $this->route('postId');

        return [
            'title' => [
                'required',
                new IsValueLengthValidRule(3, 50),
                Rule::unique('posts')->ignore($id)->whereNull('deleted_at'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute is a required field.',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => Post::TITLE . ' title',
        ];
    }
}
