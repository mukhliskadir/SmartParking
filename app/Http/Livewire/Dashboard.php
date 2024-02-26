<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\ParkingSpot;
use App\Models\EWallet;

use Carbon\Carbon;

class Dashboard extends Component
{
    public $todayGained, $monthlyGained,$totalParkingSpot,$totalEWalletBalance;
    public $monthlyData;


    public function mount()
    {
        $this->calculateTodayGained();
        $this->calculateMonthlyGained();
        $this->calculateTotalParkingSpots();
        $this->calculateTotalEWalletBalance();
        $this->fetchMonthlyData();

    }

    public function render()
    {
        return view('livewire.dashboard', [
            'todayGained' => $this->todayGained,
            'monthlyGained' => $this->monthlyGained,
            'totalParkingSpots' => $this->totalParkingSpots,
            'totalEWalletBalance' => $this->totalEWalletBalance,
            'monthlyData' => $this->monthlyData,
        ]);
    }

    private function calculateTodayGained()
    {
        $today = Carbon::today()->toDateString();

        $this->todayGained = Reservation::where('payment_status', 'paid')
            ->whereDate('created_at', $today)
            ->sum('cost');
    }

    private function calculateMonthlyGained()
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $lastDayOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $this->monthlyGained = Reservation::where('payment_status', 'paid')
            ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->sum('cost');
    }
    private function calculateTotalParkingSpots()
    {
        $this->totalParkingSpots = ParkingSpot::count();
    }
    private function calculateTotalEWalletBalance()
    {
        $this->totalEWalletBalance = EWallet::sum('balance');
    }
    private function fetchMonthlyData()
    {
        $monthlyData = [];

        $reservations = Reservation::where('payment_status', 'paid')
            ->whereDate('created_at', '>=', Carbon::now()->subMonths(12))
            ->get();

        $startDate = Carbon::now()->startOfYear();
        for ($i = 0; $i < 12; $i++) {
            $month = $startDate->copy()->addMonths($i)->format('Y-m');
            $monthlyData[$month] = 0;
        }

        foreach ($reservations as $reservation) {
            $month = Carbon::parse($reservation->created_at)->format('Y-m');
            if (isset($monthlyData[$month])) {
                $monthlyData[$month] += $reservation->cost;
            }
        }

        $this->monthlyData = $monthlyData;
    
    }

}
