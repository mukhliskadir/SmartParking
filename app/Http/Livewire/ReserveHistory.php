<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\EWallet;
use App\Models\EWalletTransaction;

class ReserveHistory extends Component
{
    public $eWalletBalance;
    public $reservationIds;
    public function render()
    {
        $user_id = auth()->id();
        $reservations = Reservation::where('user_id', $user_id)
        ->with('user')
        ->withTrashed()
        ->latest()->get();
    
    
            $eWallet = EWallet::where('user_id', $user_id)->first();
        $this->eWalletBalance = $eWallet ? number_format($eWallet->balance, 2) : number_format(0, 2);

        return view('livewire.reserve-history', [
            'reservations' => $reservations
        ])->with('eWalletBalance', $this->eWalletBalance);

    }

    public function makePayment($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $eWallet = EWallet::where('user_id', auth()->id())->firstOrFail();
        $newBalance = $eWallet->balance - $reservation->cost;
    
        if ($newBalance < 0) {
            session()->flash('error', 'Insufficient balance.');
            return redirect()->route('reserve-history');
        }
    
        $eWallet->update(['balance' => $newBalance]);
    
        EWalletTransaction::create([
            'e_wallet_id' => $eWallet->id,
            'amount' => $reservation->cost,
            'payment_method' => 'e-Wallet', 
            'type' => 'out',
            'reservation_id' => $reservation->id,
        ]);
    
        $reservation ->update(['payment_status'=>'paid']);

    
        return redirect()->route('reserve-history')->with('success', 'Payment successful.');
    }

    public function cancelRequest($reservationIds)
    {

        $reservation = Reservation::findOrFail($reservationIds);
        $reservation->update(['status' => 'cancelled']);

        $reservation->delete();

        session()->flash('success', 'Reservation cancelled successfully.');

        $this->reservationIds = null;
        return redirect()->route('reserve-history')->with('success', 'Reservation cancelled.');
        ;
    }
}

