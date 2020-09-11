<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRescheduleRequest extends FormRequest
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
            'options' => ['required', 'array', function ($attribute, $value, $fail) {
                $check_date = true;
                $check_required = true;
                if (count($value)) {
                    foreach ($value as $option) {
                        if (!empty($option['reschedule_time'])) {
                            $check_required = false;
                        }
                        if (is_numeric($option['reschedule_time'])) {
                            $check_date = false;
                        }
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
