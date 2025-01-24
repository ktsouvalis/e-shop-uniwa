@push('title')
    <title>Το Προφίλ Μου</title>
@endpush
<x-layout>
    <div>
        <div>
            <h2>Αλλαγή συνθηματικού</h2>
            <form action="{{route('change-password')}}" method="POST">
                @csrf
                <div>
                    <label for="new_password">Νέος Κωδικός</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>
                <div>
                    <label for="new_password_confirmation">Επαλήθευση κωδικού</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="bi bi-key"> Αλλαγή Κωδικού</button>
            </form>
        </div>
        <hr>

        <div>
            <h2>Διευθύνσεις</h2>
            <div>
                @foreach(auth()->user()->addresses as $address)
                    <div>
                        <div>
                            <div>
                                <h3>{{ $address->name }}</h3>
                                <p>{{ $address->address }}</p>
                                <div>
                                <form action="{{ route('address.destroy', $address) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bi bi-x-circle"></button>
                                </form>
                                <a href="{{ route('address.edit', $address) }}" class="bi bi-pencil-square"></a>
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