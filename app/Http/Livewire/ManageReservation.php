<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class ManageReservation extends Component
{
    public $search = '';
    public $searchPlate = '';
    public $reservationIds;
    public $startDate;
    public $endDate;

    public function render()
    {
        $query = Reservation::with('user')->withTrashed()->latest();

        if (!empty($this->search)) {
            $query->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }
        if (!empty($this->searchPlate)) {
            $query->where('car_plate', 'like', '%' . $this->searchPlate . '%');
        }

        if (!empty($this->startDate) && !empty($this->endDate)) {
            $startDateTime = Carbon::parse($this->startDate)->startOfDay();
            $endDateTime = Carbon::parse($this->endDate)->endOfDay();
            $query->whereBetween('reserved_at', [$startDateTime, $endDateTime]);
        }

        $reservations = $query->get();

        return view('livewire.manage-reservation', [
            'reservations' => $reservations
        ]);
    }
    public function cancelReservation()
    {
        $reservationIds = request()->input('reservationIds');
        dd($reservationIds);
        $reservation = Reservation::findOrFail($reservationIds);
        $reservation->update(['status' => 'cancelled']);
        $reservation->delete();


        $this->reservationIds = null;
        return redirect()->route('manage-reservation')->with('success', 'Reservation cancelled.');
        ;

    }

}
