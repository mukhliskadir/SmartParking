<main class="main-content">
    <div class="container-fluid py-4">
        <div>

            <div class="table-responsive p-4 ">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="table table-striped" id="ReservationHistoryTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Requester Name</th>
                            <th scope="col">Car Plate</th>
                            <th scope="col">Reserved At</th>
                            <th scope="col">Reserved Until</th>
                            <th scope="col">Status</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $index => $reservation)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $reservation->user->name }}</td>
                                <td>{{ $reservation->car_plate }}</td>
                                <td>{{ $reservation->reserved_at }}</td>
                                <td>{{ $reservation->reserved_until }}</td>
                                <td>{{ ucfirst($reservation->status) }}</td>
                                <td>{{ ucfirst($reservation->payment_status) }}</td>
                                <td>
                                    @if ($reservation->status == 'reserved')
                                        @if ($reservation->payment_status == 'pending')
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#paymentModal{{ $reservation->id }}">
                                                Make Payment
                                            </button> <button type="button" class="btn btn-danger"
                                                id="cancelRequestButton" data-bs-toggle="modal"
                                                data-bs-target="#cancelRequestModal"
                                                data-id="{{ $reservation->id }}">Cancel Request</button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="paymentModal{{ $reservation->id }}" tabindex="-1"
                                aria-labelledby="paymentModalLabel{{ $reservation->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentModalLabel{{ $reservation->id }}">Make
                                                Payment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to make payment for this reservation?</p>
                                            <p>Reservation Cost: RM{{ $reservation->cost }}</p>
                                            <p>E-Wallet Balance: RM{{ $eWalletBalance }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            @php
                                                // Remove comma from e-wallet balance
                                                $eWalletBalanceNumber = str_replace(',', '', $eWalletBalance);
                                            @endphp
                                            @if ($reservation->cost > $eWalletBalanceNumber)
                                                <button disabled class="btn btn-primary">Insufficient Balance</button>
                                            @else
                                                <button wire:click="makePayment({{ $reservation->id }})"
                                                    class="btn btn-primary">Confirm Payment</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="modal fade" id="cancelRequestModal" tabindex="-1" aria-labelledby="cancelRequestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelRequestModalLabel">Cancel Request Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this request?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form id="cancelRequestForm"
                        wire:submit.prevent="cancelRequest($event.target.reservationIds.value)">
                        <input type="hidden" name="reservationIds" id="reserve-id">
                        <button type="submit" class="btn btn-danger">Yes, Cancel Request</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#cancelRequestButton').click(function() {
                var reservationid = $(this).data('id');
                $('#reserve-id').val(reservationid);
            });
            $('#ReservationHistoryTable').DataTable();
        });
    </script>

</main>
