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
@push('links')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush
@push('scripts')
<script>
    $(document).ready(function () {
        const cartIcon = $('.bi-cart');
        const addToCartButtons = $('.add-to-cart-btn');
        const numberOfElementsPerPage = $('#number_of_products_per_page');
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
                        cartIcon.removeClass('bi-cart text-light').addClass('bi-cart-fill text-danger');
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

        numberOfElementsPerPage.on('change', function () {
            const value = $(this).val();
            const url = new URL(window.location.href);
            url.searchParams.set('limit', value);
            window.location.href = url.toString();
        });
    });
</script>
@endpush
<x-layout>
    <div class="container mt-4 my-3">
        <div class="row gy-4">
            <div class="row">
                <label for="number_of_products_per_page">Προϊόντα ανά σελίδα</label>
                <div>
                    <select class="transparent-select" id="number_of_products_per_page" name="number_of_products_per_page">
                        <option value="5" {{ request()->query('limit') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request()->query('limit') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request()->query('limit') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>
            </div>
            <div >
                <div class="search-container">
                    <form action="{{ route('index') }}" class="search-form" method="GET">
                        <div>
                            <input type="text" name="search" placeholder="Αναζήτηση προϊόντων..." value="{{ request()->query('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <!-- Preserve other filters -->
                        @foreach(request()->except('search') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                    </form>
                </div>
            </div>
            <div class="product-container">
            @foreach($products as $product)
                <x-product :product="$product" />
            @endforeach
            </div> 
        </div>
        <div class="pagination-container">
        {{ $products->links() }}
        </div>
    </div>
</x-layout>