<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        @stack('title')
        <link rel="stylesheet" href="{{asset('bootstrap-5.3.3-dist/css/bootstrap.css')}}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        @stack('links')
        <style>
            body {
                background-image: url("{{ asset("images/background.jpg") }}");
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }
        </style>
    </head>
    <body>  
    <x-navbar/>
    <x-messages/>
    {{$slot}}

    <footer class="border-top text-center small text-muted py-3">
        <p class="m-0">{{Illuminate\Support\Carbon::now()->year}} <a href="{{url("/")}}" class="text-muted">e-shop</a>. Κωνσταντίνος Τσούβαλης - Ολοκληρωμένα Περιβάλλοντα Υλικού και Λογισμικού στο Διαδίκτυο</p>
    </footer>
    <script src="{{asset('bootstrap-5.3.3-dist/js/bootstrap.js')}}"></script>
    <script
        src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
        crossorigin="anonymous">
    </script>
    @stack('scripts')
    </div> <!-- container closing -->
        <div class="d-flex justify-content-center"><p class="h3" style="color:black"> {{env('APP_NAME')}}</p></div>
    </body>
</html>