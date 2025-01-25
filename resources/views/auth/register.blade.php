@push('title')
    <title>Εγγραφή</title>
@endpush
@push('links')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush
<x-layout>
    <div class="action-container">
        <div class="action-icon bi bi-person-circle"></div>
        <form method="post" action="{{ route('register') }}" class="action-form">
            @csrf
            <div class="mb-3">
                <input class="@error('name') is-invalid @enderror" type="text" name="name" placeholder="Name" value="{{ old('name') }}" required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input class="@error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input class="@error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input class="@error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm Password" required />
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100" type="submit">Εγγραφή</button>
            </div>
            <p class="action-footer"><a href="{{ route('login') }}">Έχετε λογαριασμό; Συνδεθείτε</a></p>
        </form>
    </div>
</x-layout>