<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EWallet;
use App\Models\EWalletTransaction;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
class EWalletPage extends Component
{
    public $eWallet;
    protected $transactions;
    public $amount;

    public function render()
    {
        $this->eWallet = EWallet::where('user_id', auth()->id())->first();

        if ($this->eWallet) {
            $this->transactions = $this->eWallet->transactions()->latest()->paginate(10);
        } else {
            $this->transactions = collect();
        }

        return view('livewire.e-wallet-page', [
            'transactions' => $this->transactions
        ]);
    }


    public function makePayment()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "MYR",
                        "value" => number_format($this->amount, 2, '.', ''),
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            session()->flash('error', 'Something went wrong.');
        } else {
            session()->flash('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        $response = [
            'message' => 'Payment cancelled',
        ];
    
        return redirect()
            ->route('e-wallet')
            ->withErrors(['error' => $response['message'] ?? 'You have canceled the transaction.']);
    }

    public function paymentSuccess()
    {
        $token = request()->query('token');

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($token);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $userId = Auth::id();

            $userEwallet = Ewallet::where('user_id', $userId)->first();
            if (!$userEwallet) {
                $userEwallet = new Ewallet(['user_id' => $userId]);
            }
            $userEwallet->balance += $amount;
            $userEwallet->save();

            EwalletTransaction::create([
                'e_wallet_id' => $userEwallet->id,
                'amount' => $amount,
                'type' => 'in', 
                'payment_method' => 'Paypal'
            ]);
            return redirect()
                ->route('e-wallet')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('e-wallet')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

}