<tr>
    <td>{{ $item->name }}</td>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->price }} €</td>
    <td>{{ $item->price * $item->quantity }} €</td>
    
    @if(request()->routeIs('cart'))
    <td class="cart-item-container">
        <form action="{{route('cart.update_quantity', ['id'=>$item->id])}}" method="post">
            @csrf
            <div>
                <button type="button" onclick="this.nextElementSibling.stepDown()">-</button>
                <input type="number" name="quantity" value="{{ $item->quantity }}" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                <button type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                <button type="submit" class="bi bi-arrow-repeat" data-bs-toggle="tooltip" title="Ενημέρωση Ποσότητας"></button>
            </div>
        </form>
        <form action="{{ route('cart.remove_item', ['id' => $item->id]) }}" method="post">
            @csrf
            <button type="submit" class="bi bi-x-circle" data-bs-toggle="tooltip" title="Αφαίρεση από το καλάθι"></button>
        </form>
    </td>
    @endif
</tr>