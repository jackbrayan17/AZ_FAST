<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_number',
        'vehicle_brand',
        'vehicle_registration_number',
        'vehicle_color',
        'availability',
        'city',
        'neighborhood',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
