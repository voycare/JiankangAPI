<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsStoreRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'source' => 'required',
            'status' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category_ids' => 'required|array|array_numeric',
            'publish_date' => ['required', function ($attribute, $value, $fail) {
                $check_date = true;
                $check_required = true;
                if (!empty($value)) {
                    $check_required = false;
                }
                if (is_numeric($value)) {
                    $check_date = false;
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
