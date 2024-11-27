@push('links')
<style>
    /* Remove spinners from number input fields */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush
<tr>
    <td>{{ $item->name }}</td>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->price }} €</td>
    <td>{{ $item->price * $item->quantity }} €</td>
    
    @if(request()->routeIs('cart'))
    <td class="hstack gap-2" style="display: flex; justify-content: center; align-items: center;">
        <form action="{{route('cart.update_quantity', ['id'=>$item->id])}}" method="post">
            @csrf
            <div class="input-group input-group-sm">
                <button type="button" class="btn btn-success" onclick="this.nextElementSibling.stepDown()">-</button>
                <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control text-center" style="width: 50px;" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                <button type="button" class="btn btn-success" onclick="this.previousElementSibling.stepUp()">+</button>
                <button type="submit" class="btn btn-sm btn-primary update-quantity-btn bi bi-arrow-repeat ms-2" data-bs-toggle="tooltip" title="Ενημέρωση Ποσότητας"></button>
            </div>
        </form>
        <form action="{{ route('cart.remove_item', ['id' => $item->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger remove-item-btn bi bi-x-circle" data-bs-toggle="tooltip" title="Αφαίρεση από το καλάθι"></button>
        </form>
        <x-timer :item="$item" />
    </td>
    {{-- <td class="center-elements"></td> --}}
    @endif
</tr>