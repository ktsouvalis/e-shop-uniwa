@push('links')
<style>
    .card-body {
        background-image: url('{{ asset('images/product-card-body.jpg') }}');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
@endpush
<div>
    <div>
        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
        <div>
            <h5>{{ $product->name }}</h5>
            <p>{{ $product->description }}</p>
            <p><strong>{{ $product->price }} €</strong></p>
            @if($product->stock > 0)
            @auth
                <p>Διαθέσιμο</p>
                <div>
                    <div>
                        <label  for="q{{$product->id}}">Ποσότητα:</label>
                        <input type="number" id="q{{$product->id}}" data-quantity name="quantity" id="quantity" value="1" min="1" style="width: 60px;">
                    </div>
                    <button type="submit" data-product-id="{{ $product->id }}" data-add-to-cart-url="{{ route('add_to_cart', ['product' => $product->id]) }}" class="add-to-cart-btn">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </div>
            @endauth
            <p id="{{$product->id}}_stock">Μόνο {{ $product->stock }} απομένουν!</p>
            @else
                <p>Το προϊόν είναι εξαντλημένο!</p>
            @endif
        </div>
    </div>
</div>