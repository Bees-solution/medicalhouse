@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2 class="text-danger">❌ Payment Cancelled</h2>
    <p>You cancelled the payment. No appointment was booked.</p>
    <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Try Again</a>
</div>
@endsection
