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
    <div>
        <div>
            <div>
                <label for="number_of_products_per_page">Προϊόντα ανά σελίδα</label>
                <div>
                    <select id="number_of_products_per_page" name="number_of_products_per_page">
                        <option value="5" {{ request()->query('limit') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request()->query('limit') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request()->query('limit') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>
            </div>
            <!-- Πεδίο αναζήτησης -->
            <div>
                <div>
                    <form action="{{ route('index') }}" method="GET">
                        <div>
                            <input type="text" name="search" placeholder="Αναζήτηση προϊόντων..." value="{{ request()->query('search') }}">
                            <button type="submit">
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
            @foreach($products as $product)
                <x-product :product="$product" />
            @endforeach
        </div>
        {{ $products->links() }}
    </div>
</x-layout>