<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:50',
            //cek apakah user sudah ada atau belum
            // jika sdh ada, validasi email lewati saja
            // Ini akan lebih efisien daripada kita membuat validasi utk tambah & edit
            'email' => \request()->route('user')
                ? 'required|email|max:255|unique:users,email,' . \request()->route('user')
                : 'required|email|max:255|unique:users,email',
            'password' => \request()->route('user') ? 'nullable' : 'required|max:50'
        ];
    }
}
