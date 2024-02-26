<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdCardRequest extends FormRequest
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
            'nama' => 'required|string|max:27',
            'penempatan' => 'required|string',
            'asal' => 'required|string|max:28',
            'noHp' => 'required|string|min:10',
            'kode' =>'required|string|min:15|max:15',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
