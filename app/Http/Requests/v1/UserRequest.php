<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'username' => ['string','min:5','max:64',Rule::unique('users','username')->ignore(auth()->user()->id)],
            'firstName' => ['string','min:3','max:64'],
            'lastName' => ['string','min:3','max:64'],
            'password' => ['string','min:8','max:64'],
            'birthdayDate' => ['date'],
            'gender' => ['regex:/^(MALE)|(FEMALE)$/'],
            'profileCase' => ['regex:/^(NORMAL)|(PERIOD)|(PREGNANCY)$/'],
            'height' => ['integer','max:250'],
        ];
    }
}
