@php
    $categories = App\Models\Category::all();
@endphp
<nav id="mainNav" class="navbar navbar-expand-md sticky-top navbar-shrink py-3" style="background-color: #ffffff;">
    <div class="container"><a class="navbar-brand d-flex align-items-center bi bi-shop-window h3" href="{{route('index')}}"> eShop UniWA</a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div id="navcol-1" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                @foreach($categories as $category)
                    <li class="nav-link m-2">
                        <form action="{{ url('/') }}" method="GET" class="d-inline">
                            <input type="hidden" name="category" value="{{ $category->id }}">
                            <button type="submit" class="navbar-brand btn btn-link p-0 text-dark {{ $category->icon }}">{{ $category->name }}</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            @guest
                @if(Route::is('index'))
                <a class="nav-link shadow bi bi-door-open-fill" href="{{ route('login') }}"> Σύνδεση</a>
                @endif
            @else
            <div class="hstack gap-3">
                <div id="cart-icon">
                @php
                if(auth()->user()->cart){
                    if(auth()->user()->cart->contents()->count() > 0){
                        $icon = 'bi-cart-fill text-danger';
                    }else{
                        $icon = 'bi-cart ';
                    }
                }else{
                    $icon = 'bi-cart ';
                }
                @endphp
                <a class="nav-link bi {{$icon}}" data-bs-toggle="tooltip" title="Το καλάθι μου" href="{{ url('/cart') }}"> </a>
                </div>
                <a class="nav-link bi bi-card-list " data-bs-toggle="tooltip" title="Οι παραγγελίες μου" href="{{ url('/orders') }}"> </a>
                <a class="nav-link bi bi-person" data-bs-toggle="tooltip" title="Λογαριασμός" href="{{ url('/profile') }}"> <strong class="">{{ auth()->user()->name }}</strong>
                
                <a class="nav-link bi bi-door-closed-fill " data-bs-toggle="tooltip" title="Αποσύνδεση" href="{{ route('logout') }}"></a>  
            </div>
            @endguest
        </div>
    </div>
</nav>