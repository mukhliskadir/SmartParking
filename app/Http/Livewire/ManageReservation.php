<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reservation;

class ManageReservation extends Component
{
    public $name;
    public $date;
    public $time;
    public $reservations;
    public $loading = false;

    public function cancelReservation($reservationId)
    {
        $reservation = Reservation::find($reservationId);

        if ($reservation) {
            $reservation->delete();
            $this->loadReservations();
        }
    }

    public function resetFilters()
    {
        $this->name = null;
        $this->date = null;
        $this->time = null;
        $this->loadReservations();
    }

    public function loadReservations()
    {
        $this->loading = true;

        $query = Reservation::with('user');

        if ($this->name) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->name . '%');
            });
        }

        if ($this->date) {
            $query->whereDate('reserved_at', $this->date);
        }

        if ($this->time) {
            $query->whereTime('reserved_at', '<=', $this->time)
                ->whereTime('reserved_until', '>=', $this->time);
        }

        $this->reservations = $query->get();
        $this->loading = false;
    }

    public function render()
    {
        if (!$this->reservations) {
            $this->loadReservations();
        }

        return view('livewire.manage-reservation');
    }
}
