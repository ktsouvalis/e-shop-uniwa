@php
    $category = App\Models\Category::find(request()->segment(1)); // Get the first segment of the URL
    $user = auth()->user();
@endphp

@push('title')
    <title>
        @if($category)
            Κατηγορία: {{ $category->name }}
        @else
            Αρχική Σελίδα
        @endif
    </title>
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
                            @auth
                                <form action="{{route("add_to_cart")}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <label for="quantity">Ποσότητα:</label>
                                    <input type="text" name="quantity" value="1">

                                    <button type="submit" class="btn btn-primary bi bi-cart-plus"></button>
                                </form>
                            @endauth
                            @if($product->stock < 10 && $product->stock > 0)
                                <p class="text-primary">Μόνο {{ $product->stock }} απομένουν!</p>
                            @endif
                            @if($product->stock == 0)
                                <p class="text-danger">Το προϊόν είναι εξαντλημένο!</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>