<tr>
    <th scope="row" class="align-middle">{{ $order->id }}</th>
    <td>
        <table class="table table-bordered table table-bordered table-striped table-hover table-dark text-center">
            <thead>
                <tr>
                    <th scope="col">Περιγραφή</th>
                    <th scope="col">Ποσότητα</th>
                    <th scope="col">Τιμή Μονάδας</th>
                    <th scope="col">Σύνολο</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->contents() as $item)
                    <x-cart-item :item="$item"/>
                @endforeach
            </tbody>
        </table>
    </td>
    <td class="align-middle">{{ $order->total() }}</td>
    <td class="align-middle">{{ $order->ship_to }}</td>
    <td class="align-middle">
        @if($order->status->name == 'Processing')
            <i class="bi bi-hourglass-split text-warning"></i> {{ $order->status->name }}
        @elseif($order->status->name == 'Shipped')
            <i class="bi bi-truck text-info"></i> {{ $order->status->name }}
        @elseif($order->status->name == 'Canceled')
            <i class="bi bi-x-circle text-danger"></i> {{ $order->status->name }}
        @endif   
    </td>
    <td class="align-middle">{{ $order->created_at->format('d/m/Y') }}</td>
</tr>