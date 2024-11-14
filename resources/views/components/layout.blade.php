@php
    $categories = App\Models\Category::all();
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        @stack('title')
        <link rel="stylesheet" href="{{asset('bootstrap-5.3.3-dist/css/bootstrap.css')}}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        
        <link href="{{asset('fontawesome-free-6.6.0-web/css/fontawesome.css')}}" rel="stylesheet">
        <link href="{{asset('fontawesome-free-6.6.0-web/css/brands.css')}}" rel="stylesheet">
        <link href="{{asset('fontawesome-free-6.6.0-web/css/solid.css')}}" rel="stylesheet">
        <link href="{{asset('fontawesome-free-6.6.0-web/css/regular.css')}}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        @stack('links')
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                @auth
                    Καλώς ήρθες {{auth()->user()->name}}
                @endauth
                <a class="navbar-brand" href="{{ url('/') }}">E-Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @foreach($categories as $category)
                            <li class="nav-item">
                                <form action="{{ url('/') }}" method="GET" class="d-inline">
                                    <input type="hidden" name="category" value="{{ $category->id }}">
                                    <button type="submit" class="nav-link btn btn-link p-0 {{$category->icon}}">{{ $category->name }}</button>
                                </form>
                            </li>
                        @endforeach
                        @guest
                            <li class="nav-item">
                                <a class="nav-link bi bi-door-open-fill" href="{{ route('login') }}"> Σύνδεση</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link bi bi-door-closed-fill" href="{{ route('logout') }}"> Αποσύνδεση</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bi bi-cart2" href="{{ url('/cart') }}"> Καλάθι</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bi bi-card-list" href="{{ url('/orders') }}"> Παραγγελίες</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    @include('components.messages')
    {{$slot}}

    <footer class="border-top text-center small text-muted py-3">
        <p class="m-0">{{Illuminate\Support\Carbon::now()->year}} <a href="{{url("/")}}" class="text-muted">e-shop</a>. Κωνσταντίνος Τσούβαλης - Ολοκληρωμένα Περιβάλλοντα Υλικού και Λογισμικού στο Διαδίκτυο</p>
    </footer>
    <script src="{{asset('bootstrap-5.3.3-dist/js/bootstrap.js')}}"></script>
    {{-- <script
        src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
        crossorigin="anonymous">
    </script> --}}

    @stack('scripts')
    </div> <!-- container closing -->
        <div class="d-flex justify-content-center"><p class="h3" style="color:black"> {{env('APP_NAME')}}</p></div>
    </body>
</html>