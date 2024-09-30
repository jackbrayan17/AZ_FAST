<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storekeeper extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_number',
        'availability',
        'city',
        'neighborhood',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
