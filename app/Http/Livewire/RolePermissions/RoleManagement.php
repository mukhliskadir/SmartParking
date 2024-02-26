<?php

namespace App\Http\Livewire\RolePermissions;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagement extends Component
{
    public $roles;
    public $roleName;
    public $permissions;
    public $selectedRole;
    public $showPermissions = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function render()
    {
        return view('livewire.role-permissions.role-management');
    }

    public function createRole()
    {
        // Logic for creating role
    }

    public function editRolePermissions($roleId)
    {
        $this->selectedRole = $roleId;
        $this->showPermissions[$roleId] = true;
    }

    public function updateRolePermissions()
    {
        // Logic for updating role permissions
    }

    public function hidePermissions($roleId)
    {
        $this->selectedRole = null;
        $this->showPermissions[$roleId] = false;
    }
}
