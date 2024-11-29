@push('title')
    <title>Ιστορικό Παραγγελιών</title>
@endpush
<x-layout>
    <div class="container mt-5">
        <h2>Ιστορικό Παραγγελιών</h2>
        @if($orders->isEmpty())
            <p>Δεν έχετε παραγγελίες στο ιστορικό σας</p>
        @else
        <table class="table table-bordered table-striped table-hover table-dark text-center">
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
        @endif
    </div>
</x-layout>