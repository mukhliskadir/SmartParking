<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ParkingSpot;

class ParkingSpots extends Component
{
    public $name;
    public $size ='';
    public $selectedSpotId;

    protected $rules = [
        'name' => 'required',
        'size' => 'required',
    ];

    public function render()
    {
        $spots = ParkingSpot::all();
        return view('livewire.parking-spots', compact('spots'));
    }

    public function create()
    {
        $this->resetForm();
        $this->selectedSpotId = null;
    }

    public function store()
    {
        $this->validate();
        
        $price_per_ten_min = 0.1;
        if ($this->size === 'Medium') {
            $price_per_ten_min = 0.2;
        } elseif ($this->size === 'Large') {
            $price_per_ten_min = 0.3;
        }
    
        ParkingSpot::create([
            'name' => $this->name,
            'size' => $this->size,
            'price_per_ten_min' => $price_per_ten_min,
        ]);
        $this->resetForm();
    }

    public function edit($id)
    {
        $spot = ParkingSpot::findOrFail($id);
        $this->selectedSpotId = $id;
        $this->name = $spot->name;
        $this->size = $spot->size;
    }

    public function update()
    {
        $this->validate();
    
        $spot = ParkingSpot::findOrFail($this->selectedSpotId);
        $spot->update([
            'name' => $this->name,
            'size' => $this->size,
        ]);
    
        $price_per_ten_min = 0.1; 
        if ($this->size === 'Medium') {
            $price_per_ten_min = 0.2;
        } elseif ($this->size === 'Large') {
            $price_per_ten_min = 0.3;
        }
    
        $spot->update(['price_per_ten_min' => $price_per_ten_min]);
    
        $this->resetForm();
    }
    

    public function delete($id)
    {
        ParkingSpot::findOrFail($id)->delete();
    }

    protected function resetForm()
    {
        $this->name = '';
        $this->size = '';
    }
}