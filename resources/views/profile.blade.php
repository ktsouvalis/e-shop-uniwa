@push('title')
    <title>Το Προφίλ Μου</title>
@endpush
<x-layout>
    <style>
        .address-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px;
            background-color: #f9f9f9;
            width: calc(33% - 20px);
            box-sizing: border-box;
        }
        .addresses-wrapper {
            display: flex;
            flex-wrap: wrap;
        }
        .address-container h3 {
            margin: 0;
        }
        .address-container p {
            margin: 5px 0;
        }
        .address-container button, .address-container a {
            margin-left: 5px;
            margin-bottom: 8px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .address-container button {
            background-color: #dc3545;
            color: white;
        }
        .address-container a {
            background-color: #007bff;
            color: white;
        }
        .address-container button:hover {
            background-color: #c82333;
        }
        .address-container a:hover {
            background-color: #0056b3;
        }
    </style>
    <div>
        <div class="action-container">
            <h2>Αλλαγή συνθηματικού</h2>
            <form class="action-form" action="{{route('change-password')}}" method="POST">
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
            <div class="addresses-wrapper">
                @foreach(auth()->user()->addresses as $address)
                    <div class="address-container">
                        <div>
                            <h3>{{ $address->name }}</h3>
                            <p>{{ $address->address }}</p>
                        </div>
                        <div>
                            <form action="{{ route('address.destroy', $address) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bi bi-x-circle"></button>
                            </form>
                            <a href="{{ route('address.edit', $address) }}" class="bi bi-pencil-square"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <x-add-address />
</x-layout>