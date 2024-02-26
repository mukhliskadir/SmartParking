<main class="main-content">
    <div class="container-fluid py-4">
        {{-- Tables --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-body">
  
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
                          
                    <div>
                        <form wire:submit.prevent="makePayment">
                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3">
                                    <label for="amount" class="form-label">Enter Amount (RM)</label>
                                    <input wire:model="amount" type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" step="0.01" min="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn bg-gradient-dark btn-md">
                                        <i class="fab fa-paypal"></i> Top-up with PayPal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
  
                </div>
                <div class="card">
                    <div class="card-header">E-Wallet Balance</div>

                    <div class="card-body">
                        @if ($eWallet)
                            <h5 class="card-title">Your E-Wallet Balance: MYR{{ $eWallet->balance }}</h5>

                            <h6 class="card-subtitle mb-2 text-muted">Recent Transactions:</h6>
                            <table class="min-w-full divide-y divide-gray-200" id="transactionTable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($transaction->type === 'in')
                                                    <span class="badge badge-sm bg-gradient-success">
                                                        In
                                                    </span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">
                                                        Out
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">MYR{{ $transaction->amount }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap" colspan="3">No transactions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            

                            {{-- {{ $transactions->links() }} --}}
                        @else
                            <p>No e-wallet found for the authenticated user, please topup first.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</main>

