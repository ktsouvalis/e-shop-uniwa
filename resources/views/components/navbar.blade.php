@php
    $categories = App\Models\Category::all();
@endphp
<nav id="mainNav">
    <div class="container">
        <a class="bi bi-shop-window" href="{{route('index')}}"> eShop UniWA</a>
        <ul class="navbar-nav">
            @foreach($categories as $category)
                <li class="nav-link">
                    <form action="{{ url('/') }}" method="GET" class="d-inline">
                        <input type="hidden" name="category" value="{{ $category->id }}">
                        <button type="submit" class="{{ $category->icon }}">{{ $category->name }}</button>
                    </form>
                </li>
            @endforeach
        </ul>
        @guest
            <div class="guest-links">
                @if(Route::is('index'))
                    <a class="bi bi-door-open-fill" href="{{ route('login') }}"> Σύνδεση</a>
                @endif
            </div>
        @else
            <div class="user-links">
                <div id="cart-icon">
                    @php
                    if(auth()->user()->cart){
                        if(auth()->user()->cart->contents()->count() > 0){
                            $icon = 'bi-cart-fill text-danger';
                        }else{
                            $icon = 'bi-cart';
                        }
                    }else{
                        $icon = 'bi-cart';
                    }
                    @endphp
                    <a class="bi {{$icon}}" title="Το καλάθι μου" href="{{ url('/cart') }}"></a>
                </div>
                <a class="bi bi-card-list" title="Οι παραγγελίες μου" href="{{ url('/orders') }}"></a>
                <a class="bi bi-person" title="Λογαριασμός" href="{{ url('/profile') }}">
                    <strong>{{ auth()->user()->name }}</strong>
                </a>
                <a class="bi bi-door-closed-fill" title="Αποσύνδεση" href="{{ route('logout') }}"></a>
            </div>
        @endguest
    </div>
</nav>