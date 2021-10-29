<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GudangRequest extends FormRequest
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
        $rules = [
            'nama' => 'required|unique:gudang,nama|string',
            'lokasi' => 'required',
            'status' => 'required',
        ];
        if ($this->method() == 'PUT') {
            $id = $this->gudang->id;
            $rules['nama'] = 'required|unique:gudang,nama,' . $id;
        }
        return $rules;
    }
}
