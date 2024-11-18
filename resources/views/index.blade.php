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
                <x-product :product="$product" />
            @endforeach
        </div>
    </div>
</x-layout>