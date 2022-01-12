<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'username' => $this->username,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'phone' => $this->phone,
            'birthdayDate' => $this->birthday_date,
            'gender' => $this->gender,
            'profileCase' => $this->profile_case,
            'height' => $this->height,
        ];
    }
}
