<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class AttendantsRequest extends FormRequest
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
            'relation' => ['string','min:3','max:64'],
            'name' => ['string','required','min:3','max:64'],
            'phone' => ['regex:/09(1[0-9]|9[0-9]|0[0-9]|3[0-9]|2[0-9])-?[0-9]{3}-?[0-9]{4}/','required'],
        ];
    }
}
