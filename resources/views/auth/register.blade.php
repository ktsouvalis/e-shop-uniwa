@push('title')
    <title>Register</title>
@endpush
<x-layout>
    <div class="text-center d-flex flex-column align-items-center">
        <div class="bi bi-person-circle my-4"></div>
        <form method="post" action="{{ route('register') }}" class="w-50">
            @csrf
            <div class="mb-3">
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Name" value="{{ old('name') }}" required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm Password" required />
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100" type="submit">Register</button>
            </div>
            <p class="text-muted"><a href="{{ route('login') }}" class="text-center">Έχετε λογαριασμό; Συνδεθείτε</a></p>
        </form>
    </div>
</x-layout>