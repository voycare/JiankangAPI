<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClinicAvaiableStoreRequest extends FormRequest
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
            'clinic_available' => ['required', function ($attribute, $value, $fail) {
                $check_date = true;
                $check_required = true;
                if (count($value)) {
                    if (!empty($value['date'])) {
                        $check_required = false;
                    }
                    if (is_numeric($value['date'])) {
                        $check_date = false;
                    }
                }

                if ($check_required) {
                    return $fail('The ' . $attribute . ' need date required');
                }

                if ($check_date) {
                    return $fail('The ' . $attribute . ' need date timestamp');
                }
            }]
        ];
    }
}
