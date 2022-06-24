@extends(config('constant.site_view').'layouts.app', ["title" => "Chi tiết đơn hàng"])

@php
    $orderItems = $order->orderItems;
    $shipping_ward = App\Models\Ward::find(intval($order->shipping_ward_id));
    $shipping_district = $shipping_ward->district;
    $shipping_province = $shipping_district->province;
@endphp
@section('content')
    <div class="row">
        @auth
            @include(config('constant.site_view').'layouts.sidebarCustomer')
        @endauth
        <div class="col-md-9 order-info">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="home-title">Đơn hàng #{{ $order->id }}</h4>
                </div>
                <div class="clearfix"></div>
                <aside class="col-md-7 cart-checkout">
                    @foreach ($orderItems as $orderItem)
                        @php
                            $product = $orderItem->product;
                        @endphp
                        <div class="row">
                            <div class="col-xs-2">
                                <img class="img-responsive" src="{{ asset('') }}images/{{ $product->featured_image }}" alt="{{ $product->name }}"> 
                            </div>
                            <div class="col-xs-7">
                                <a class="product-name" href="{{ route('product.show', ["product" => $product->id]) }}">{{ $product->name }}</a>
                                <br>
                                <span>{{ $orderItem->qty }}</span> x <span>{{ number_format($orderItem->unit_price) }}₫</span>
                            </div>
                            <div class="col-xs-3 text-right">
                                <span>{{ number_format($orderItem->unit_price * $orderItem->qty) }}₫</span>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="row">
                        <div class="col-xs-6">
                            Tạm tính
                        </div>
                        <div class="col-xs-6 text-right">
                            {{ number_format($order->price_total) }}₫
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            Giảm giá
                        </div>
                        <div class="col-xs-6 text-right discount">
                            - {{ number_format($order->discount_amount) }}₫
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            Tổng tiền
                        </div>
                        <div class="col-xs-6 text-right sub-total">
                            {{ number_format($order->sub_total) }}₫
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            VAT:
                        </div>
                        <div class="col-xs-6 text-right vat">
                            {{ number_format($order->tax) }}₫
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            Tổng tiền bao gồm VAT:
                        </div>
                        <div class="col-xs-6 text-right temp-total" >
                            {{ number_format($order->price_inc_tax_total) }}₫
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            Voucher:
                        </div>
                        <div class="col-xs-6 text-right voucher">
                            - {{ number_format($order->voucher_amount) }}₫
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            Phí vận chuyển
                        </div>
                        <div class="col-xs-6 text-right">
                            {{ number_format($order->shipping_fee) }}₫
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6">
                            Tổng cộng
                        </div>
                        <div class="col-xs-6 text-right">
                            {{ number_format($order->payment_total) }}₫
                        </div>
                    </div>
                </aside>
                <div class="ship-checkout col-md-5">
                    <h4>Thông tin giao hàng</h4>
                    <div>
                        Họ và tên: {{ $order->shipping_fullname }}
                    </div>
                    <div>
                        Số điện thoại: {{ $order->shipping_mobile }}
                    </div>
                    <div>
                        Địa chỉ giao hàng: {{ $order->shipping_housenumber_street . " ," .$shipping_ward->name . ", " . $shipping_district->name . ", " . $shipping_province->name }}
                        
                    </div>
                    <div>
                        Phương thức thanh toán: 
                        {{ $order->payment_method == 0 ? "COD" : "Bank" }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection