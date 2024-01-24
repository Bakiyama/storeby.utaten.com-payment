@extends('layouts.default')

@section('content')
    @foreach (App\Enums\OrderPaymentMethod::asSelectArray() as $value => $description)
        <p><a href="{{ route('orders.store', ['payment_method' => $value]) }}">{{ $description }}</a></p>
    @endforeach
@endsection