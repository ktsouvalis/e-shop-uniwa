@php
    $cart = auth()->user()->cart;
@endphp
<x-layout>
    <div class="container mt-4">
        <h2>Το Καλάθι Μου</h2>
        
        @if($cart && $cart->contents()->isEmpty())
            <p>Το καλάθι σας είναι άδειο.</p>
        @elseif($cart)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Προϊόν</th>
                        <th>Ποσότητα</th>
                        <th>Τιμή</th>
                        <th>Σύνολο</th>
                        <th>Ενέργειες</th>
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
            <a href="{{ route('checkout') }}" class="btn btn-primary">Ολοκλήρωση Αγοράς</a>
        @else
            <p>Το καλάθι σας είναι άδειο.</p>
        @endif
    </div>
</x-layout>