<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'parking_spot_id',
        'car_model',
        'car_plate',
        'reserved_at',
        'reserved_until',
        'duration',
        'status',
        'cost',
        'payment_status',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
