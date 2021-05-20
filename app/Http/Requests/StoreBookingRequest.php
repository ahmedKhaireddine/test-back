<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'attributes' => 'required',
            'attributes.date' => 'date_format:Y-m-d H:i|required_with:attributes',
            'doctor_id' => 'exists:doctors,id|required',
        ];
    }
}
