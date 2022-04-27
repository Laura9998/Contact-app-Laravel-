@if ($message = session('message'))
    <div class="alert alert-success">{{ $message }}</div>
@endif
