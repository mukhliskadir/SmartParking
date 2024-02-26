<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;
use App\Http\Livewire\ParkingSpots;
use App\Http\Livewire\EWalletPage;
use App\Http\Controllers\PayPalController;
use App\Http\Livewire\ParkingReservation;
use App\Http\Livewire\ManageCars;
use App\Http\Livewire\ReserveHistory;
use App\Http\Livewire\ManageReservation;

use App\Http\Livewire\RolePermissions\RoleManagement;

use App\Http\Livewire\RolePermissions\UserProfile;
use App\Http\Livewire\RolePermissions\UserManagement;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/user-profile', UserProfile::class)->name('user-profile');
    Route::get('/user-management', UserManagement::class)->name('user-management');
    Route::get('/role-management', RoleManagement::class)->name('role-management');
    Route::get('/parking-spots', ParkingSpots::class)->name('parking-spots');
    Route::get('/e-wallet', EWalletPage::class)->name('e-wallet');
    Route::get('/reservation', ParkingReservation::class)->name('reservation');
    Route::get('/manage-cars', ManageCars::class)->name('manage-cars');
    Route::get('/reserve-history', ReserveHistory::class)->name('reserve-history');
    Route::get('/manage-reservation', ManageReservation::class)->name('manage-reservation');


    Route::get('/paypal/payment/success', [EWalletPage::class, 'paymentSuccess'])->name('success.payment');
    Route::get('/paypal/payment/cancel', [EWalletPage::class, 'paymentCancel'])->name('cancel.payment');
    
});

