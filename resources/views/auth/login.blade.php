@push('title')
    <title>Login</title>
@endpush
<x-layout>
    <div class="card-body text-center d-flex flex-column align-items-center">
        <div class="bi bi-person-circle my-4"></div>
        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email" /></div>
            <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" /></div>
            <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Σύνδεση</button></div>
            <p class="text-muted"><a href="{{ route('register') }}" class="text-center">Δεν έχετε λογαριασμό; Εγγραφείτε</a></p>
        </form>
    </div>
</x-layout>