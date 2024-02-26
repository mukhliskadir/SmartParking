<!-- role-management.blade.php -->

<div>
    <form wire:submit.prevent="createRole">
        <!-- Form for creating roles -->
    </form>

    <!-- Display roles and permission editing interface -->
    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" wire:click="editRolePermissions({{ $role->id }})">Edit Permissions</button>
                    </td>
                </tr>
                @if($selectedRole === $role->id && $showPermissions[$role->id])
                <tr wire:key="permissions-row-{{ $role->id }}">
                    <td colspan="3">
                        <form wire:submit.prevent="updateRolePermissions">
                            @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}" value="{{ $permission->name }}" wire:model="selectedRolePermissions">
                                    <label class="form-check-label" for="{{ $permission->name }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary mt-2">Update Permissions</button>
                            <button type="button" class="btn btn-secondary mt-2" wire:click="hidePermissions({{ $role->id }})">Cancel</button>
                        </form>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
