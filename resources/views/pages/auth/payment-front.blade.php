@extends('pages.auth.layout')
@section('title', 'Payment Page')
@section('content')
<span class="login100-form-title p-b-53">
    <img src="/assets/img/brand/blue.png" width="250px" />
    <br>

</span>
<h3> Payment for {{$plan->title}}</h3>
<hr>
<br>
<h5> Total: ${{$plan->price}} </h5>
<br>
<br>

<form action="/pay" method="POST">
    @csrf
    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="{{env('STRIPE_KEY')}}" data-amount="{{$plan->price}}00" data-name="{{$plan->title}} Membership"
        data-description="Argon Membership" data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-local="auto" data-currency="usd">
    </script>
    <input type="hidden" name="username" value="{{$data->username}}" />
    <input type="hidden" name="pass" value="{{$data->pass}}" />
    <input type="hidden" name="email" value="{{$data->email}}" />
    <input type="hidden" name="plan" value="{{$plan->id}}" />
    <input type="hidden" name="description" value="Payment for {{$plan->title}}" />
    <input type="hidden" name="amount" value="{{$plan->price}}" />
</form>
@stop