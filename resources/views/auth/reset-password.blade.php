<x-layout>
    <div class="action-container">
        <div class="action-icon bi bi-person-circle"></div>
        <form method="post" action="{{ route('reset-password') }}" class="action-form">
            @csrf
            <div><input type="email" name="email" placeholder="Email" value="{{old('email')}}" required/></div>
            <div><button type="submit">Ανάκτηση Κωδικού</button></div>
            <p class="action-footer"><a href="{{ route('register') }}">Δεν έχετε λογαριασμό; Εγγραφείτε</a></p>
            <p class="action-footer"><a href="{{ route('login') }}">Έχετε λογαριασμό; Συνδεθείτε</a></p>
        </form>
    </div>
</x-layout>