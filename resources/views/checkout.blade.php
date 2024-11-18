<x-layout>
    <div class="container mt-5">
        <table class="table table-bordered">
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
    <div class="container mt-5">
        <h2 class="mb-4">Checkout</h2>
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="address" class="form-label">Select Address</label>
                <select class="form-control" id="address" name="address">
                    @foreach(auth()->user()->addresses as $address)
                        <option value="{{ $address->id }}">{{ $address->address }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="cardNumber" class="form-label">Credit Card Number</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required>
            </div>
            <div class="form-group mb-3">
                <label for="cardName" class="form-label">Name on Card</label>
                <input type="text" class="form-control" id="cardName" name="cardName" placeholder="John Doe" required>
            </div>
            <div class="form-group mb-3">
                <label for="expiryDate" class="form-label">Expiry Date</label>
                <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
            </div>
            <div class="form-group mb-4">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Place Order</button>
        </form>
    </div>
</x-layout>