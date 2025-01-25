@push('links')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush
<div class="action-container">
    <h2>Προσθήκη Διεύθυνσης</h2>
    <form action="{{ route('address.store') }}" method="POST" class="action-form">
        @csrf
        <div>
            <label for="name">Ονοματεπώνυμο</label>
            <input type="text" id="name" name="name" placeholder="Το όνομά σας" required>
        </div>
        <div>
            <label for="address">Οδός και Αριθμός</label>
            <input type="text" id="address" name="address" placeholder="Αραχώβης 15" required>
        </div>
        <div>
            <label for="city">Πόλη</label>
            <input type="text" id="city" name="city" placeholder="Αθήνα" required>
        </div>
        <div>
            <label for="zip">Τ.Κ.</label>
            <input type="text" id="zip" name="zip" placeholder="12345" required>
        </div>
        <button type="submit">Add Address</button>
    </form>
</div>
