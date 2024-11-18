<tr>
    <td>{{ $item->name }}</td>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->price }} €</td>
    <td>{{ $item->price * $item->quantity }} €</td>
    @if(request()->routeIs('cart'))
    <td class="hstack gap-2">
        <form action="{{route('cart.update_quantity', ['id'=>$item->id])}}" method="post">
            @csrf
            <div class="hstack gap-2">
            <input type="number" name="quantity" value="{{ $item->quantity }}">
            <button type="submit" class="btn btn-sm btn-primary update-quantity-btn bi bi-arrow-repeat" data-bs-toggle="tooltip" title="Ενημέρωση Καλαθιού"></button>
            </div>
        </form>
        <form action="{{ route('cart.remove_item', ['id' => $item->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger remove-item-btn bi bi-x-circle" data-bs-toggle="tooltip" title="Αφαίρεση από το καλάθι"></button>
        </form>
    </td>
    @endif
</tr>