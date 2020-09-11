<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClinicCreateRequest extends FormRequest
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
            'type_clinic' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'website' => 'required',
            'year_in_business' => 'required|numeric',
            'contact_person' => 'required',
            'title' => 'required',
            'country' => 'required',
            'city' => 'required',
            'language_spokens' => 'required'
        ];
    }
}
