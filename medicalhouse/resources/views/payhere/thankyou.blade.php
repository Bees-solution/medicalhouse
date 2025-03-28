@extends('layouts.app') {{-- Or use your own layout --}}

@section('content')
<div class="container text-center mt-5">
    <h2 class="text-success">🎉 Payment Successful!</h2>
    <p>Your appointment has been confirmed. You'll receive an SMS shortly.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Back to Home</a>
</div>
@endsection
