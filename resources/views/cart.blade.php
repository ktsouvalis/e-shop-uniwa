@php
    $cart = auth()->user()->cart;
@endphp
@push('title')
    <title>Το Καλάθι Μου</title>
@endpush

<x-layout>
    <div class="container mt-4">
        <h2>Το Καλάθι Μου</h2>
        
        @if($cart && $cart->contents()->isEmpty())
            <p>Το καλάθι σας είναι άδειο.</p>
        @elseif($cart)
            <table class="cart-table">
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
            <div>
                <strong>Συνολικό Ποσό: {{ $cart->contents()->sum(fn($item) => $item->price * $item->quantity) }} €</strong>
            </div>
            <a  href="{{ route('checkout') }}" 
                style=" display: inline-block; 
                        padding: 10px 20px; 
                        background-color: #007bff; 
                        color: white; 
                        text-align: center; 
                        border-radius: 5px; 
                        text-decoration: none;">Ολοκλήρωση Αγοράς
            </a>
        @else
            <p>Το καλάθι σας είναι άδειο.</p>
        @endif
    </div>
</x-layout>