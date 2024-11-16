@php
    $user = auth()->user();
@endphp

@push('title')
    <title>
        @if(request()->query('category'))
            Κατηγορία: {{ App\Models\Category::find(request()->query('category'))->name }}
        @else
            Αρχική Σελίδα
        @endif
    </title>
@endpush
@push('scripts')
<script>
    $(document).ready(function () {
    const cartIcon = $('.bi-cart');
    const addToCartButtons = $('.add-to-cart-btn');

    addToCartButtons.on('click', function (event) {
        event.preventDefault();
        const productId = $(this).data('product-id');
        const addToCartUrl = $(this).data('add-to-cart-url');
        const quantity = $(this).closest('.hstack').find('[data-quantity]').val();

        $.ajax({
            url: addToCartUrl,
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({ product_id: productId, quantity: quantity }),
            success: function (data) {
                console.log(data);
                if (data.status === 'success') {
                    // Update cart icon with a red badge
                    cartIcon.removeClass('bi-cart').addClass('bi-cart-fill text-danger');
                    // Show success alert
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            },
            error: function (error) {
                console.error('Error:', error);
                alert('Υπήρξε πρόβλημα με την προσθήκη του προϊόντος στο καλάθι.');
            }
        });
    });
});
</script>
@endpush
<x-layout>
    <div class="container mt-4 my-3">
        <div class="row gy-4">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card h-auto shadow">
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text"><strong>{{ $product->price }} €</strong></p>
                            @if($product->stock > 0)
                            @auth
                                <p class="card-text text-success">Διαθέσιμο</p>
                                
                                    <div class="hstack gap-2">
                                    <div class="me-2">
                                        <label for="quantity" class="form-label d-none">Ποσότητα:</label>
                                        <input type="number" class="form-control form-control-sm" data-quantity name="quantity" id="quantity" value="1" min="1" style="width: 60px;">
                                    </div>
                                    <button type="submit" data-product-id="{{ $product->id }}" data-add-to-cart-url="{{ route('add_to_cart', ['product' => $product->id]) }}" class="btn btn-primary btn-sm add-to-cart-btn">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            @endauth
                            <p class="text-primary my-2">Μόνο {{ $product->stock }} απομένουν!</p>
                            @else
                                <p class="text-danger">Το προϊόν είναι εξαντλημένο!</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>