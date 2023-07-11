@extends('main')
 
@section('content')
<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                Products
            </div>
            <div class="card-body">
            @foreach ($products as $product)
                <div class="row row-cols-auto">
                    <div class="col-8">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{$product->price}}€</p>
                    </div>
                    <div class="col">
                        <form method="POST" action="{{route('order.addToCart')}}">
                            @csrf
                            <input type="hidden" name="productId" value="{{$product->id}}">
                            <input type="submit" class="btn btn-primary" value="Add To Cart" />
                        </form>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                Voucher
            </div>
            <ul class="list-group list-group-flush">
            @foreach ($vouchers as $voucher)
                <li class="list-group-item">
                {{$voucher->description}}
                @php $isAppliedVoucher = array_search($voucher->id, session('cart.vouchers',[])); @endphp
                @if($isAppliedVoucher === false)
                    <form method="POST" action="{{route('order.applyVoucher')}}">
                        @csrf
                        <input type="hidden" name="voucherId" value="{{$voucher->id}}">
                        <input type="submit" class="btn btn-primary" value="Apply" />
                    </form>
                @else
                    <form method="POST" action="{{route('order.removeVoucher')}}">
                        @csrf
                        <input type="hidden" name="voucherId" value="{{$voucher->id}}">
                        <input type="submit" class="btn btn-primary" value="Remove" />
                    </form>
                @endif
            </li>
            @endforeach
            </ul>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                Cart Summary
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h5 class="">Total</h5>
                    <p class="">{{session('cart.cartTotal')}}</p>
                    <h5 class="">Discounts</h5>
                    @foreach(session('cart.discounts',[]) as $discounts)
                    @php $key = array_search($voucher->id, session('cart.vouchers',[])); @endphp
                        @if($key !== false)
                        <p class="">{{session('cart.vouchers'.'.'.$key)}}</p>
                        <p class="">{{$discounts.value}}</p>
                        @endif
                    @endforeach
                    <h5 class="">Grand Total</h5>
                    <p>{{session('cart.totalDiscount')}}</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Cart
            </div>
            <table class="table">
                <thead>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </thead>
                <tbody>
               @foreach($products=session('cart.products',[]) as $product)
                    <tr>
                        <td>{{$product['name']}}</td>
                        <td>€{{$product['price']}}</td>
                        <td>€{{$product['price'] * $product['qty']}}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <form method="POST" action="{{route('order.removeFromCart')}}"  class="me-3">
                                    @csrf
                                    <input type="hidden" name="action" value="removeOneFromCart">
                                    <input type="hidden" name="productId" value="{{$product['id']}}">
                                    <button type="submit" class="btn btn-success">
                                        -
                                    </button>
                                </form>
                                {{ $product['qty'] }}
                                <form method="POST" action="{{route('order.addToCart')}}" class="ms-3">
                                    @csrf
                                    <input type="hidden" name="productId" value="{{$product['id']}}">
                                    <button type="submit" class="btn btn-success">
                                        +
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="{{route('order.removeFromCart')}}">
                                @csrf
                                <input type="hidden" name="action" value="removeAllFromCart">
                                <input type="hidden" name="productId" value="{{$product['id']}}">
                                <button type="submit" class="btn btn-danger">
                                    Remove All
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
        </div>
    </div>
   
</div>
@endsection