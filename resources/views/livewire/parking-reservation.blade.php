<main class="main-content">
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h3>Search for Available Parking Spots</h3>
            <form wire:submit.prevent="submit" wire:reset="resetReservationForm">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="date" class="form-label">Date:</label>
                        <input type="date" id="date" class="form-control" wire:model="date"
                               min="{{ now()->format('H') < 17 ? now()->format('Y-m-d') : now()->addDay()->format('Y-m-d') }}">
                    </div>  
                    
                    <div class="col-md-4 mb-3">
                        <label for="time" class="form-label">Time From:</label>
                        <input type="time" id="time" class="form-control" wire:model="time"
                            min="{{ $isTodaySelected ? now()->format('H:i') : '09:00' }}" max="16:00" wire:change="updateTimeToMin">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="timeTo" class="form-label">Time To:</label>
                        <input type="time" id="timeTo" class="form-control" wire:model="timeTo"
                            min="{{ $minTimeTo }}" max="17:00">
                    </div>
                    
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" wire:click="clearList">Clear List</button>
            </form>
        
            <!-- Display available parking spots -->
            @if ($availableParkingSpots)
            @if ($availableParkingSpots->count() > 0)
                <h4>Available Parking Spots:</h4>
                <div class="row">
                    <div class="col-lg-6">
                <ul class="list-group">
                    @foreach ($availableParkingSpots as $parkingSpot)
                        <li class="list-group-item  d-flex justify-content-between align-items-center p-2">
                            <span>{{ $parkingSpot->name }} - {{ $parkingSpot->size }}</span>
                            <span>Price Per 10 minutes : RM {{ $parkingSpot->price_per_ten_min }}</span>
                            <button class="btn btn-secondary btn-sm" wire:click="showReservationForm({{ $parkingSpot->id }})">Reserve</button>
                        </li>
                    @endforeach
                </ul>
                    </div>
                </div>
            @else
                <p class="mt-3">No available parking spots for the selected date and time.</p>
            @endif
        @endif
        
        
            <div>
                @if ($showForm)
                    <!-- Reservation Form -->
                    <form wire:submit.prevent="reserve">
                        <div class="row">
                            <!-- Car Model and Plate -->
                            <div class="col-md-6 mb-3">
                                <label for="carModel" class="form-label">Car Model:</label>
                                <input type="text" id="carModel" class="form-control" wire:model.defer="carModel">
                                @error('carModel') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="carPlate" class="form-label">Car Plate:</label>
                                <input type="text" id="carPlate" class="form-control" wire:model.defer="carPlate">
                                @error('carPlate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <!-- Date and Time -->
                            <div class="col-md-6 mb-3">
                                <label for="dateTimeFrom" class="form-label">Date Time From:</label>
                                <input type="text" id="dateTimeFrom" class="form-control" value="{{ $date }} {{ $time }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dateTimeTo" class="form-label">Date Time To:</label>
                                <input type="text" id="dateTimeTo" class="form-control" value="{{ $date }} {{ $timeTo }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Duration and Parking Spot Name -->
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label">Duration (in minutes):</label>
                                <input type="text" id="duration" class="form-control" value="{{ $this->calculateDuration() }}" readonly>
                            </div>
                               <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label">Price:</label>
                                <input type="text" id="price" class="form-control" value="RM {{ $this->calculatePrice() }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="parkingSpotName" class="form-label">Parking Spot Name:</label>
                                <input type="text" id="parkingSpotName" class="form-control" value="{{ $selectedParkingSpot->name }}" readonly>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Reserve</button>
                    </form>
                @endif
            </div>
        </div>
        
    </div>
</main>
