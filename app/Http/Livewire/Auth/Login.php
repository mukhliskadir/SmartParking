<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required',
    ];

    public function mount() {
        if (auth()->check()) {
            if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')) {
                return redirect('/dashboard');        
            } else {
                return redirect('/reservation');
            }
        }
        
        $this->fill(['email' => 'admin@softui.com', 'password' => 'secret']);
    }
    
    
    public function login() {
        $credentials = $this->validate();
        if(auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')) {
                return redirect('/dashboard');        
            } else {
                return redirect('/reservation');
            }
        } else {
            return $this->addError('email', trans('auth.failed')); 
        }
    }
    

    public function render()
    {
        return view('livewire.auth.login');
    }
}
