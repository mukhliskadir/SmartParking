<div>
    <input type="text" wire:model="name" placeholder="Search by name">
    <input type="date" wire:model="date" placeholder="Search by date">
    <input type="time" wire:model="time" placeholder="Search by time">
    
    <button wire:click="resetFilters">Reset</button>
    
    @if($reservations->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->reserved_at}}</td>
                        <td>{{ $reservation->reserved_at}}</td>
                        <td>
                            <button wire:click="cancelReservation({{ $reservation->id }})">Cancel</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No reservations found.</p>
    @endif
    
    @if($loading)
        <p>Loading...</p>
    @endif
</div>