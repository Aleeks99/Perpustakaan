<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        if ($user->hasRole('admin')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:128',
            'publisher' => 'nullable|string|max:128',
            'year' => 'nullable|numeric',
            'category' => 'required|string',
            'isbn' => 'required|string|max:24|unique:books,ISBN',
            'description' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berisi huruf.',
            'title.max' => 'Judul berisi maksimal 255 karakter.',
            'author.string' => 'Penulis harus berisi huruf.',
            'author.max' => 'Penulis berisi maksimal 128 karakter.',
            'year.numeric' => 'Tahun harus berisi huruf.',
            'category.required' => 'Kategori harus diisi.',
            'category.string' => 'Kategori harus berisi huruf.',
            'isbn.required' => 'ISBN harus diisi.',
            'isbn.string' => 'ISBN harus berisi huruf atau angka.',
            'isbn.max' => 'ISBN berisi maksimal 24 karakter.',
            'isbn.unique' => 'ISBN telah digunakan.',
            'description.string' => 'Deskripsi harus berisi huruf.'
        ];
    }
}
