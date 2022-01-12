<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalInformation extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'special_disease',
        'diabetes',
        'blood_pressure',
        'kidney_failure',
        'heart_problem',
        'special_disease_list',
        'doctor_list',
        'heart_doctor',
        'kidney_doctor',
        'women_doctor',
        'interior_doctor',
        'medicine_list',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
