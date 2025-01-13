@push('title')
    <title>Το Προφίλ Μου</title>
@endpush
<x-layout>
    <div class="container">
        <div class="change-password">
            <h2>Change Password</h2>
            <form action="{{route('change-password')}}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <label for="new_password">Νέος Κωδικός</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>
                <div class="form-group mb-2">
                    <label for="new_password_confirmation">Επαλήθευση κωδικού</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary bi bi-key"> Αλλαγή Κωδικού</button>
            </form>
        </div>
        <hr>

        <div class="addresses">
            <h2>Addresses</h2>
            <div class="row">
                @foreach(auth()->user()->addresses as $address)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3>{{ $address->name }}</h3>
                                <p class="card-text">{{ $address->address }}</p>
                                <div class="hstack gap-2">
                                <form action="{{ route('address.destroy', $address) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger bi bi-x-circle"></button>
                                </form>
                                <a href="{{ route('address.edit', $address) }}" class="btn btn-primary bi bi-pencil-square"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>

        <x-add-address />
</x-layout>