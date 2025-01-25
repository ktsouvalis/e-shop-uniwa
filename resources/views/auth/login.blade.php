@push('title')
    <title>Login</title>
@endpush
@push('links')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush
<x-layout>
    <div class="action-container">
        <div class="action-icon bi bi-person-circle"></div>
        <form method="post" action="{{ route('login') }}" class="action-form">
            @csrf
            <div><input type="email" name="email" placeholder="Email" value="{{old('email')}}" required/></div>
            <div><input type="password" name="password" placeholder="Password" required/></div>
            <div><button type="submit">Σύνδεση</button></div>
        </form>
        <p class="action-footer"><a href="{{ route('register') }}">Δεν έχετε λογαριασμό; Εγγραφείτε</a></p>
    </div>
</x-layout>