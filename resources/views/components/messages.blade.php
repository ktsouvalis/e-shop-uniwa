@if (session()->has('success'))
    <div >
        <div class='alert alert-success'>
        {{session('success')}}
        </div>
    </div>
@endif

@if(session()->has('failure'))
    <div >
    <div class='alert alert-danger'>
        {{session('failure')}}
    </div>
    </div>
 @endif
    
 @if(session()->has('warning'))
    <div >
    <div class='alert alert-warning'>
        {{session('warning')}}
    </div>
    </div>
 @endif 
