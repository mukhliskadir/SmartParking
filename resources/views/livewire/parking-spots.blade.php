<main class="main-content">
    <div class="container-fluid py-4">
        {{-- Tables --}}
        <div>
            <!-- Create or Edit Form -->
            <form wire:submit.prevent="{{ $selectedSpotId ? 'update' : 'store' }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" wire:model="name" placeholder="Name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
               
                    <div class="col-md-6 mb-3">
                        <label for="size" class="form-label">Size</label>
                        <select class="form-select" id="size" wire:model="size">
                            <option value="" disabled selected>Select parking size</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                        </select>
                        @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                </div>
            
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{ $selectedSpotId ? 'Update' : 'Create' }}</button>
                    </div>
                </div>
            </form>
            
        
                    
            <!-- List of Parking Spots -->
            <table class="table" id="ParkingSpotTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Price Per Ten Minutes</th>
                        <th>Actions</th>
                    </tr>
                </thead> 
                <tbody>
                    @foreach ($spots as $spot)
                        <tr>
                            <td>{{ $spot->name }}</td>
                            <td>{{ $spot->size }}</td>
                            <td style="width: 20%">RM{{ $spot->price_per_ten_min }}</td>
                            <td>
                                <button class="btn btn-warning" wire:click="edit({{ $spot->id }})">Edit</button>
                                <button class="btn btn-danger" wire:click="delete({{ $spot->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            </div>
</main>

