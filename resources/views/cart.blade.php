<x-layout>
    <div class="container mt-4">
        <h2>Το Καλάθι Μου</h2>
        @if($cart->contents()->isEmpty())
            <p>Το καλάθι σας είναι άδειο.</p>
        @else
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
                            <td>
                                <input type="number" class="form-control form-control-sm quantity-input" data-product-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1">
                            </td>
                            <td>{{ $item->price }} €</td>
                            <td>{{ $item->price * $item->quantity }} €</td>
                            <td>
                                <button class="btn btn-sm btn-primary update-quantity-btn bi bi-arrow-repeat" data-bs-toggle="tooltip" title="Ενημέρωση Καλαθιού" data-update-url="{{route("cart.update_quantity",['id'=>$item->id])}}" data-product-id="{{ $item->id }}"></button>
                                <button class="btn btn-sm btn-danger remove-item-btn bi bi-x-circle" data-bs-toggle="tooltip" title="Αφαίρεση από το καλάθι" data-product-id="{{ $item->id }}"></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <strong>Συνολικό Ποσό: {{ $cart->contents()->sum(fn($item) => $item->price * $item->quantity) }} €</strong>
            </div>
        @endif
    </div>
    @push('scripts')
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
                        alert(data.message);
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
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error:', error);
                        alert('Υπήρξε πρόβλημα με την αφαίρεση του προϊόντος.');
                    }
                });
            });
        });
    </script>
    @endpush
</x-layout>