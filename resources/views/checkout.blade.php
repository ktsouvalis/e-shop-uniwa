@push('title')
    <title>Checkout</title>
@endpush
<x-layout>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Προϊόν</th>
                    <th>Ποσότητα</th>
                    <th>Τιμή Μονάδας</th>
                    <th>Σύνολο</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($cart->contents() as $item)
                    <x-cart-item :item="$item"/>
                @endforeach
            </tbody>
        </table>
        <div class="text-end">
            <strong>Συνολικό Ποσό: {{ $cart->contents()->sum(fn($item) => $item->price * $item->quantity) }} €</strong>
        </div>
    </div>
    <div>
        <h2>Checkout</h2>
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div>
                <label for="address" class="form-label">Select Address</label>
                <select id="address" name="address">
                    @foreach(auth()->user()->addresses as $address)
                        <option value="{{ $address->id }}">{{$address->name}}: {{ $address->address }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="cardNumber" class="form-label">Αριθμός Κάρτας</label>
                <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required>
            </div>
            <div>
                <label for="cardName" class="form-label">Όνομα κατόχου</label>
                <input type="text" id="cardName" name="cardName" placeholder="John Doe" required>
            </div>
            <div>
                <label for="expiryDate" class="form-label">Ημερομηνία Λήξης</label>
                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
            </div>
            <div>
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="123" required>
            </div>
            @if(auth()->user()->addresses->count())
                <button type="submit" class="btn btn-primary w-100">Υποβολή παραγγελίας</button>
            @else
                <p>Πρέπει να καταχωρίσετε μια διεύθυνση πριν υποβάλλετε παραγγελίες</p>
            @endif
        </form>
    </div>
    
    <div>
        <h2>Προσθήκη Νέας Διεύθυνσης</h2>
        <x-add-address />
    </div>
</x-layout>