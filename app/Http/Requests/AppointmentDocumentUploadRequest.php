<?php

namespace App\Http\Requests;

use App\Models\AppointmentDocument;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentDocumentUploadRequest extends FormRequest
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
            'type' => 'required|in:' . AppointmentDocument::SUPPORT . ',' . AppointmentDocument::TRANSLATE,
            'doc' => 'required|max:4096'
        ];
    }
}
