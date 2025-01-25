<tr>
    <th>{{ $order->id }}</th>
    <td>
        <table class="order-items-table">
            <thead>
                <tr>
                    <th>Περιγραφή</th>
                    <th>Ποσότητα</th>
                    <th>Τιμή Μονάδας</th>
                    <th>Σύνολο</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->contents() as $item)
                    <x-cart-item :item="$item"/>
                @endforeach
            </tbody>
        </table>
    </td>
    <td>{{ $order->total() }}</td>
    <td>{{ $order->ship_to }}</td>
    <td>
        @if($order->status->name == 'Processing')
            <i class="bi bi-hourglass-split"></i> {{ $order->status->name }}
        @elseif($order->status->name == 'Shipped')
            <i class="bi bi-truck"></i> {{ $order->status->name }}
        @elseif($order->status->name == 'Canceled')
            <i class="bi bi-x-circle"></i> {{ $order->status->name }}
        @endif   
    </td>
    <td class="align-middle">{{ $order->created_at->format('d/m/Y') }}</td>
</tr>