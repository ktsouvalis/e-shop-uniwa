@push('scripts')
<script>
    $(document).ready(function () {
        const item = @json($item);
        const countdownDuration = 15 * 60 * 1000;

        function updateCountdown() {
            const now = new Date().getTime();
            const itemElement = $(`#countdown-${item.id} span`);
            const itemAddedAt = new Date(item.time_added).getTime();
            const distance = countdownDuration - (now - itemAddedAt);

            if (distance <= 0) {
                $.ajax({
                    url: '{{ route("clear-cart") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: item.id
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            } else {
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                if(seconds < 10) {
                    seconds = `0${seconds}`;
                }
                if (minutes < 10) {
                    minutes = `0${minutes}`;
                }
                itemElement.html(`${minutes}:${seconds}`);
            }
        }

        // Update the countdown every second
        setInterval(updateCountdown, 1000);
    });
</script>
@endpush
<div id="countdown-{{ $item->id }}" class="card bg-warning text-dark m-1 px-1 center-timer" style="width: 75px; margin-left: auto;">
    <div class="d-flex align-items-center small">
        <i class="bi bi-hourglass-split me-2"></i>
        <span></span>
    </div>
</div>
