<x-layout>
<div class="container">
    <h2>Edit Address</h2>
    @php
        $parts = explode(', ', $address->address);
    @endphp
    <form action="{{ route('address.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name">Όνομα</label>
            <input type="text" id="name" name="name" value="{{ $address->name }}" required>
        </div>

        <div>
            <label for="address">Οδός και Αριθμός</label>
            <input type="text" id="address" name="address" value="{{ $parts[0] }}" required>
        </div>

        <div>
            <label for="city">Πόλη</label>
            <input type="text" id="city" name="city" value="{{ $parts[1] }}" required>
        </div>

        <div>
            <label for="zip">Τ.Κ.</label>
            <input type="text" id="zip" name="zip" value="{{ $parts[2] }}" required>
        </div>

        <button type="submit" class="bi bi-floppy"> Αποθήκευση</button>
    </form>
    <a href="{{ route('address.edit', $address) }}" class="bi bi-arrow-counterclockwise">Αναίρεση</a>
    <a href="{{ route('profile') }}" class="bi bi-backspace"> Επιστροφή</a>
</div>
</x-layout>
