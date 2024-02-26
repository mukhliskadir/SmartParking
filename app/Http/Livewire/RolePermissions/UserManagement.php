<?php

namespace App\Http\Livewire\RolePermissions;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Add this line
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    public $users, $name, $email, $password, $status, $userId;

    public function mount()
    {
        $this->users = User::with('roles')->get();
    }

    public function render()
    {
        return view('livewire.role-permissions.user-management');
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password), 
        ]);

        $user->assignRole('admin');

        session()->flash('message', 'Admin created successfully!');

        $this->reset();
        return redirect()->route('user-management'); 

    }

    public function updateUsers()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::findOrFail($this->userId);
        $user -> update([
            'name' => $this->name,
            'email' => $this->email,
            'status' =>$this->status,
        ]);


        session()->flash('message', 'User edited successfully!');

        $this->reset();
    }
}
