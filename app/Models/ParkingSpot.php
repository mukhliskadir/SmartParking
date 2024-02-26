<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSpot extends Model
{
    protected $fillable = ['name', 'size','price_per_ten_min'];

    use HasFactory;
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
