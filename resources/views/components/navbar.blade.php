@php
    $categories = App\Models\Category::all();
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="{{ url('/') }}">E-Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto m-2 mb-lg-0">
                @foreach($categories as $category)
                    <li class="nav-item m-2">
                        <form action="{{ url('/') }}" method="GET" class="d-inline">
                            <input type="hidden" name="category" value="{{ $category->id }}">
                            <button type="submit" class="nav-link btn btn-link p-0 text-light {{ $category->icon }}"> {{ $category->name }}</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <span class="navbar-text ms-auto text-light">
                @guest
                    <a class="nav-link bi bi-door-open-fill text-light" href="{{ route('login') }}"> Σύνδεση</a>
                @else
                <div class="hstack gap-3">
                    {{-- @if(auth()->user()->cart and !request()->routeIs('cart'))
                        <x-timer/>
                    @endif --}}
                    <div id="cart-icon">
                    @php
                    if(auth()->user()->cart){
                        if(auth()->user()->cart->contents()->count() > 0){
                            $icon = 'bi-cart-fill text-danger';
                        }else{
                            $icon = 'bi-cart text-light';
                        }
                    }else{
                        $icon = 'bi-cart text-light';
                    }
                    @endphp
                    <a class="nav-link bi {{$icon}}" data-bs-toggle="tooltip" title="Το καλάθι μου" href="{{ url('/cart') }}"> </a>
                    </div>
                    <a class="nav-link bi bi-card-list text-light" data-bs-toggle="tooltip" title="Οι παραγγελίες μου" href="{{ url('/orders') }}"> </a>
                    <strong class="text-light">{{ auth()->user()->name }}</strong>
                    
                    <a class="nav-link bi bi-door-closed-fill text-light" data-bs-toggle="tooltip" title="Αποσύνδεση" href="{{ route('logout') }}"></a>  
                </div>
                @endguest
            </span>
        </div>
    </div>
</nav>