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
            <p id="{{$product->id}}_stock" class="text-primary my-2">Μόνο {{ $product->stock }} απομένουν!</p>
            @else
                <p class="text-danger">Το προϊόν είναι εξαντλημένο!</p>
            @endif
        </div>
    </div>
</div>