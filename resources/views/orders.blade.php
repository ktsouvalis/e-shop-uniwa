<x-layout>
    <div class="container mt-5">
        <h2>Your Orders</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="align-middle">Order ID</th>
                    <th scope="col">Items</th>
                    <th scope="col" class="align-middle">Total</th>
                    <th scope="col" class="align-middle">Ship To</th>
                    <th scope="col" class="align-middle">Status</th>
                    <th scope="col" class="align-middle">Order Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <th scope="row" class="align-middle">{{ $order->id }}</th>
                    <td>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->contents() as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->quantity * $item->price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td class="align-middle">{{ $order->total() }}</td>
                    <td class="align-middle">{{ $order->ship_to }}</td>
                    <td class="align-middle">{{ $order->status->name }}</td>
                    <td class="align-middle">{{ $order->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>