@php
    $cart = auth()->user()->cart;   
@endphp
@push('scripts')
<script>
    $(document).ready(function () {
        const cartCreatedAt = new Date("{{ optional($cart)->created_at }}").getTime();
        const countdownElement = $('#countdown span');
        const countdownDuration = 30 * 60 * 1000;

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = countdownDuration - (now - cartCreatedAt);
            if (distance <= 0) {
                $.ajax({
                    url: '{{ route("clear-carts") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
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
                countdownElement.html(`${minutes}:${seconds}`);
            }
        }

        // Update the countdown every second
        setInterval(updateCountdown, 1000);
    });
</script>
@endpush
<div id="countdown" class="card bg-warning mb-3 text-end p-3" style="width: 100px; margin-left: auto;">
    <div class="d-flex align-items-center small">
        <i class="bi bi-hourglass-split me-2"></i>
        <span></span>
    </div>
</div>