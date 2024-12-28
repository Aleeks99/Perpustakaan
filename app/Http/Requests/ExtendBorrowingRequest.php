<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtendBorrowingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        if ($user->hasRole('librarian')) {
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
        $old_date = $this->input('old_date');
        return [
            'old_date' => 'required|date',
            'date' => 'required|date|after:' . $old_date
        ];
    }

    public function messages()
    {
        return [
            'old_date.required' => 'Tanggal harus diisi.',
            'old_date.date' => 'Tanggal harus berupa Tanggal.',
            'date.required' => 'Batas waktu harus diisi.',
            'date.date' => 'Batas waktu harus berupa Tanggal.',
            'date.after' => 'Batas waktu tidak boleh kurang dari sebelumnya.'
        ];
    }
}
