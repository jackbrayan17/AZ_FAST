<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function client() {
        return $this->belongsTo(Client::class);
    }
    
    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
    
    public function delivery() {
        return $this->hasOne(Delivery::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    }
