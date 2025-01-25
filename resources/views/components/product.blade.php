@push('links')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
<style>
    .card-body {
        background-image: url('{{ asset('images/product-card-body.jpg') }}');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
@endpush
<div class="product-col">
    <div class="product-card">
        <img src="{{ asset('images/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
        <div class="card-body">
            <h5 class="product-title">{{ $product->name }}</h5>
            <p class="product-description">{{ $product->description }}</p>
            <p class="product-price"><strong>{{ $product->price }} €</strong></p>
            @if($product->stock > 0)
            @auth
                <p class="product-available text-success">Διαθέσιμο</p>
                <div class="hstack gap-2">
                    <div class="quantity-input">
                        <label for="q{{$product->id}}" class="form-label d-none">Ποσότητα:</label>
                        <input type="number" id="q{{$product->id}}" class="form-control form-control-sm" data-quantity name="quantity" value="1" min="1" style="width: 60px;">
                    </div>
                    <button type="submit" data-product-id="{{ $product->id }}" data-add-to-cart-url="{{ route('add_to_cart', ['product' => $product->id]) }}" class="btn btn-primary btn-sm add-to-cart-btn">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </div>
            @endauth
            <p id="{{$product->id}}_stock" class="product-stock text-primary my-2">Μόνο {{ $product->stock }} απομένουν!</p>
            @else
                <p class="product-out-of-stock text-danger">Το προϊόν είναι εξαντλημένο!</p>
            @endif
        </div>
    </div>
</div>