<x-layout>
<div class="container">
    <h2>Edit Address</h2>
    @php
        $parts = explode(', ', $address->address);
        // dd($parts);
    @endphp
    <form action="{{ route('address.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-2">
            <label for="name">Όνομα</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $address->name }}" required>
        </div>

        <div class="form-group mb-2">
            <label for="address">Οδός και Αριθμός</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $parts[0] }}" required>
        </div>

        <div class="form-group mb-2">
            <label for="city">Πόλη</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ $parts[1] }}" required>
        </div>

        <div class="form-group mb-2">
            <label for="zip">Τ.Κ.</label>
            <input type="text" class="form-control" id="zip" name="zip" value="{{ $parts[2] }}" required>
        </div>

        <button type="submit" class="btn btn-primary bi bi-floppy mb-2"> Αποθήκευση</button>
    </form>
    <a href="{{ route('address.edit', $address) }}" class="btn btn-secondary bi bi-arrow-counterclockwise mb-2">Αναίρεση</a>
    <a href="{{ route('profile') }}" class="btn btn-secondary bi bi-backspace mb-2"> Επιστροφή</a>
</div>
</x-layout>
