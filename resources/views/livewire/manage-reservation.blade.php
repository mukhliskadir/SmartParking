<main class="main-content">
    <div class="container-fluid py-4">
        {{-- Tables --}}
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="search">Search by name</label>
                        <input type="text" class="form-control" id="search" wire:model="search"
                            placeholder="Enter name">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="searchPlate">Search by plate number</label>
                        <input type="text" class="form-control" id="searchPlate" wire:model="searchPlate"
                            placeholder="Enter plate number">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="startDate">From</label>
                        <input type="date" class="form-control" id="startDate" wire:model="startDate"
                            placeholder="Select start date">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="endDate">To</label>
                        <input type="date" class="form-control" id="endDate" wire:model="endDate"
                            placeholder="Select end date">
                    </div>
                </div>
                
            </div>


            <div class="col-md-12">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Car Plate</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status / Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->user->name }}</td>
                                <td>{{ $reservation->car_plate }}</td>
                                <td>{{ $reservation->reserved_at }}</td>
                                <td>{{ $reservation->reserved_until }}</td>
                                <td>{{ $reservation->status }} /  {{$reservation->payment_status }} </td>
                                <td>
                                    @if ($reservation->payment_status == 'pending' &&  $reservation->status=='reserved')
                                        <a class="cancelReservation" id="cancelReservation" data-bs-toggle="modal"
                                        data-bs-target="#cancelReservationModal"
                                        data-id="{{ $reservation->id }}">
                                            <i class="fas fa-user-edit text-secondary"> Cancel Reservation</i>
                                    @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="cancelReservationModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelReservationModal">Cancel Request Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this request?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form wire:submit.prevent="cancelReservation">
                        <input type="hidden" wire:model="reservationIds" name="reservationIds" id="reserve-id">
                        <button type="submit" class="btn btn-danger">Yes, Cancel Request</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.cancelReservation').click(function() {
                var reservationIds = $(this).data('id');
                $('#reserve-id').val(reservationIds);
            });
        });
    </script>