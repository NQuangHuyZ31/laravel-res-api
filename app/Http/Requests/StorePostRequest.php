<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return [
            //
            'title'=> 'required|string|min:2',
            'body' => ['required','string','min:2'],
            'author_id' => ['required'],
            'tag' => 'array',
            'tag.*' => 'string|min:2'
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'title.required' => 'Title is required',
    //         'title.string' => 'Title MUST BE valid string required',
    //         'title.min' => 'Title is min two string required',
    //     ];
    // }
}
