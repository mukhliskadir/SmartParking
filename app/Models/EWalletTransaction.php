<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EWalletTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['e_wallet_id', 'amount', 'type', 'reservation_id','payment_method'];

    public function eWallet()
    {
        return $this->belongsTo(EWallet::class);
    }
}
