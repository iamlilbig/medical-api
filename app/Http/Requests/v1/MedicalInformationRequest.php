<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class MedicalInformationRequest extends FormRequest
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
            'specialDisease' => ['required','boolean'],
            'diabetes' => ['required','boolean'],
            'bloodPressure' => ['required','boolean'],
            'kidneyFailure' => ['required','boolean'],
            'heartProblem' => ['required','boolean'],
            'specialDiseaseList' => ['json'],
            'doctorList' => ['json'],
            'heartDoctor' => ['string'],
            'kidneyDoctor' => ['string'],
            'womenDoctor' => ['string'],
            'interiorDoctor' => ['string'],
            'medicineList' => ['json'],
        ];
    }
}
