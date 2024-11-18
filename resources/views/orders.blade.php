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
                    <x-order :order="$order" />
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>