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
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }} €</td>
                            <td>{{ $item->price * $item->quantity }} €</td>
                            <td class="hstack gap-2">
                                <form action="{{route('cart.update_quantity', ['id'=>$item->id])}}" method="post">
                                    @csrf
                                    <div class="hstack gap-2">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}">
                                    <button type="submit" class="btn btn-sm btn-primary update-quantity-btn bi bi-arrow-repeat" data-bs-toggle="tooltip" title="Ενημέρωση Καλαθιού"></button>
                                    </div>
                                </form>
                                <form action="{{ route('cart.remove_item', ['id' => $item->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger remove-item-btn bi bi-x-circle" data-bs-toggle="tooltip" title="Αφαίρεση από το καλάθι"></button>
                                </form>
                            </td>
                        </tr>
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
    {{-- @push('scripts')
    <script>
        $(document).ready(function () {
            $('.update-quantity-btn').on('click', function () {
                const productId = $(this).data('product-id');
                const quantity = $(this).closest('tr').find('.quantity-input').val();
                const updateUrl = $(this).data('update-url');

                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({ quantity: quantity }),
                    success: function (data) {
                        // alert(data.message);
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                    
                });
            });

            $('.remove-item-btn').on('click', function () {
                const productId = $(this).data('product-id');
                const removeUrl = '{{ route("cart.remove_item", ":id") }}'.replace(':id', productId);

                $.ajax({
                    url: removeUrl,
                    method: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        // location.reload();
                    },
                    error: function (error) {
                        console.error('Error:', error);
                        // alert('Υπήρξε πρόβλημα με την αφαίρεση του προϊόντος.');
                    }
                });
            });
        });
    </script>
    @endpush --}}
</x-layout>