<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalInformation extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'specialDisease' => $this->special_disease,
            'diabetes' => $this->diabetes,
            'bloodPressure' => $this->blood_pressure,
            'kidneyFailure' => $this->kidney_failure,
            'heartProblem' => $this->heart_problem,
            'specialDiseaseList' => $this->special_disease_list,
            'doctorList' => $this->doctor_list,
            'heartDoctor' => $this->heart_doctor,
            'kidneyDoctor' => $this->kidney_doctor,
            'womenDoctor' => $this->women_doctor,
            'interiorDoctor' => $this->interior_doctor,
            'medicineList' => $this->medicine_list,
        ];
    }
}
