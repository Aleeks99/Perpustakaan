<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|numeric|max_digits:15',
            'gender' => 'required',
            'address' => 'nullable|string|max:255',
            'nisn' => 'required|numeric|max_digits:10|unique:students,nisn',
            'classroom' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berisi huruf.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Masukan isian dalam format email.',
            'email.unique' => 'Email telah digunakan.',
            'phone.numeric' => 'Nomor ponsel harus berupa angka.',
            'phone.max_digits' => 'Nomor ponsel berisi maksimal 15 digit.',
            'gender.required' =>  'Jenis kelamin harus diisi.',
            'address.string' => 'Alamat harus berisi huruf atau angka.',
            'address.max' => 'Alamat berisi maksimal 255 karakter.',
            'nisn.required' => 'NISN harus diisi.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'nisn.max_digits' => 'NISN berisi maksimal 10 digit.',
            'nisn.unique' => 'NISN telah digunakan.',
            'classroom.required' => 'Kelas harus diisi.'
        ];
    }
}
