<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslatorStoreRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:translators',
            'wechat' => 'required',
            'phone' => 'required',
            'current_location' => 'required',
            'nationality' => 'required',
            'national_id' => 'required',
            'languages' => 'array'
        ];
    }
}
