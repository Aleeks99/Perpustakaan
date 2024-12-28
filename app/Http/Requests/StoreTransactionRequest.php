<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        if ($user->hasRole('librarian') || $user->hasRole('admin')) {
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
        $now = date('Y-m-d');
        return [
            'bookID' => 'required',
            'memberID' => 'required',
            'date' => 'required|date|after:'.$now
        ];
    }

    public function messages()
    {
        return [
            'bookID.required' => 'Pilih buku terlebih dahulu.',
            'memberID.required' => 'Pilih peminjam terlebih dahulu.',
            'date.required' => 'Batas waktu harus diisi.',
            'date.date' => 'Batas waktu harus berupa tanggal.',
            'date.after' => 'Batas waktu tidak boleh kurang dari hari ini.'
        ];
    }
}
