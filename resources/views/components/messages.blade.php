<div class="alert-container">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('failure'))
        <div class="alert alert-danger">
            {{ session('failure') }}
        </div>
    @endif

    @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
</div>
