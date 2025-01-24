@push('title')
    <title>Ιστορικό Παραγγελιών</title>
@endpush
<x-layout>
    <div >
        <h2>Ιστορικό Παραγγελιών</h2>
        @if($orders->isEmpty())
            <p>Δεν έχετε παραγγελίες στο ιστορικό σας</p>
        @else
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Ship To</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <x-order :order="$order" />
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</x-layout>