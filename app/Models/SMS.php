<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    use HasFactory;

    protected $table = 'SMS';

    protected $fillable=[
        'user_id',
        'massage',
        'code',
        'massage_type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
