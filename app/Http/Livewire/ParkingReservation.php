<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ParkingSpot;
use App\Models\Reservation;
use Carbon\Carbon;

class ParkingReservation extends Component
{
    public $date, $time, $timeTo, $carModel, $carPlate, $userReservations, $availableParkingSpots, $selectedParkingSpotId, $showForm = false, $minTimeTo, $price_per_ten_min;

    protected $rules = [
        'carModel' => 'required|string',
        'carPlate' => 'required|string',
    ];

    public function mount()
    {
        $this->setDefaultDateTime();
    }

    public function setDefaultDateTime()
    {
        $this->date = now()->format('Y-m-d');
        $currentHour = now()->format('H');
        $this->time = sprintf('%02d:00', $currentHour);

        if ($currentHour < 9 || $currentHour >= 17) {
            $this->time = '09:00';
            $this->date = now()->addDay()->format('Y-m-d');
        }

        $this->timeTo = Carbon::parse($this->time)->addHour()->format('H:i');
    }

    public function showReservationForm($parkingSpotId)
    {
        $this->selectedParkingSpotId = $parkingSpotId;
        $parkingSpot = ParkingSpot::find($parkingSpotId);
        $this->price_per_ten_min = $parkingSpot->price_per_ten_min;
        $this->showForm = true;
    }

    public function reserve()
    {
        $this->validate();

        Reservation::create([
            'user_id' => auth()->user()->id,
            'parking_spot_id' => $this->selectedParkingSpotId,
            'car_model' => $this->carModel,
            'car_plate' => $this->carPlate,
            'reserved_at' => Carbon::parse($this->date . ' ' . $this->time),
            'reserved_until' => Carbon::parse($this->date . ' ' . $this->timeTo),
            'duration' => $this->calculateDuration(),
            'cost' => $this->calculatePrice(),
        ]);

        $this->reset(['showForm', 'carModel', 'carPlate']);

        return redirect()->route('reserve-history')->with('success','Parking reserved, please make payment');
    }

    public function render()
    {
        return view('livewire.parking-reservation', [
            'isTodaySelected' => $this->isTodaySelected(),
            'selectedParkingSpot' => ParkingSpot::find($this->selectedParkingSpotId),
        ]);
    }

    public function isTodaySelected()
    {
        return Carbon::parse($this->date)->isToday();
    }

    public function submit()
    {
        $selectedDateTime = Carbon::parse($this->date . ' ' . $this->time);
        $currentDateTime = Carbon::now();

        if ($selectedDateTime < $currentDateTime) {
            $this->dispatchBrowserEvent('showMessage', ['message' => 'You cannot select a time in the past.']);
            return;
        }

        $dateTimeFrom = Carbon::parse($this->date . ' ' . $this->time);
        $dateTimeTo = Carbon::parse($this->date . ' ' . $this->timeTo);
        $this->availableParkingSpots = $this->getAvailableParkingSpots($dateTimeFrom, $dateTimeTo);
    }

    public function clearList()
    {
        $this->availableParkingSpots = collect();
        $this->showForm = false;
    }

    public function calculateDuration()
    {
        $dateTimeFrom = Carbon::parse($this->date . ' ' . $this->time);
        $dateTimeTo = Carbon::parse($this->date . ' ' . $this->timeTo);
        return $dateTimeFrom->diffInMinutes($dateTimeTo);
    }

    public function calculatePrice()
    {
        $duration = $this->calculateDuration();
        $price = ($duration / 10) * $this->price_per_ten_min;
        return $price;
    }

    public function updateTimeToMin()
    {
        $timeFrom = Carbon::parse($this->time);
        $this->minTimeTo = $timeFrom->addMinutes(10)->format('H:i');
    }

    public function getAvailableParkingSpots($dateTimeFrom, $dateTimeTo)
    {
        return ParkingSpot::whereDoesntHave('reservations', function ($query) use ($dateTimeFrom, $dateTimeTo) {
            $query->where(function ($query) use ($dateTimeFrom, $dateTimeTo) {
                $query->whereBetween('reserved_at', [$dateTimeFrom, $dateTimeTo])
                    ->orWhereBetween('reserved_until', [$dateTimeFrom, $dateTimeTo]);
            });
        })->get();
    }
}
