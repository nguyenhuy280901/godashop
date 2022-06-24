@extends(config('constant.site_view').'layouts.app', ['title' => 'Thanh toán'])

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/" target="_self">Giỏ hàng</a></li>
                <li><span>/</span></li>
                <li class="active"><span>Thông tin giao hàng</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <aside class="col-md-6 cart-checkout">
            @foreach ($cart as $item)
                <div class="row">
                    <div class="col-xs-2">
                        <img class="img-responsive" src="{{ asset('') }}images/{{ $item->options["featured_image"] }}" alt="{{ $item->name }}"> 
                    </div>
                    <div class="col-xs-7">
                        <a class="product-name" href="{{ route('product.show', ["product" => $item->id]) }}">{{ $item->name }}</a> 
                        <br>
                        <span>{{ $item->qty }}</span> x <span>{{ number_format($item->price) }}₫</span>
                    </div>
                    <div class="col-xs-3 text-right">
                        <span>{{ number_format($item->subtotal) }}₫</span>
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="row">
                <div class="col-xs-6">
                    Tạm tính
                </div>
                <div class="col-xs-6 text-right price-total">
                    {{ Cart::priceTotal() }}₫
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    Giảm giá
                </div>
                <div class="col-xs-6 text-right discount">
                    - {{ Cart::discount() }}₫
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    Tổng tiền
                </div>
                <div class="col-xs-6 text-right sub-total">
                    {{ Cart::subtotal() }}₫
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    VAT:
                </div>
                <div class="col-xs-6 text-right vat">
                    {{ Cart::tax() }}₫
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    Tổng tiền bao gồm VAT:
                </div>
                <div class="col-xs-6 text-right temp-total" data="{{ Cart::total(0, "", "") }}">
                    {{ Cart::total() }}₫
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    Voucher:
                </div>
                @php
                    $voucher_amount = session()->get('voucher_amount') ?? 0;
                @endphp
                <div class="col-xs-6 text-right voucher" data='{{$voucher_amount}}'>
                    - {{ number_format($voucher_amount) }}₫
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    Phí vận chuyển
                </div>
                <div class="col-xs-6 text-right">
                    @php
                        $shippingfee = $transport->price ?? 0
                    @endphp
                    <span class="shipping-fee" data="{{ $shippingfee }}">{{ number_format($shippingfee) }}₫</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <form action="{{route('cart.discount')}}" id="use-discount">
                        <div class="row mb-2">
                            <div class="col-xs-10 pr-0">
                                <input class="form-control" type="text" name="discount-code" id="discount-code" placeholder="Mã giảm giá" value="{{ request()->session()->get("discount_code") }}">
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-info">Sử dụng</button>
                            </div>
                        </div>
                        <div class="alert alert-danger">
                            {{ request()->session()->get("error_discount_code") ?? "" }}
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <form action="{{route('cart.voucher')}}" id="use-voucher">
                        <div class="row mb-2">
                            <div class="col-xs-10 pr-0">
                                <input class="form-control" type="text" name="voucher-code" id="voucher-code" placeholder="Mã voucher" value="{{ request()->session()->get("voucher_code") }}">
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-info">Sử dụng</button>
                            </div>
                        </div>
                        <div class="alert alert-danger">
                            {{ request()->session()->get("error_voucher_code") ?? "" }}
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    Tổng cộng
                </div>
                <div class="col-xs-6 text-right">
                    @php
                        $total = Cart::total(0, "", "") + $shippingfee - $voucher_amount
                    @endphp
                    <span class="payment-total">{{ number_format($total) }}₫</span>
                </div>
            </div>
            <hr>
            <div class="label-for-submit">
                <label for="submit" class="btn btn-md btn-primary pull-right">Hoàn tất đơn hàng</label>
            </div>
        </aside>
        <div class="ship-checkout col-md-6">
            <h4>Thông tin giao hàng</h4>
            @guest
                <div>Bạn đã có tài khoản? <a href="javascript:void(0)" class="btn-login">Đăng Nhập  </a></div>
            @endguest
            <br>
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <input type="hidden" name="shippingfee" value="{{ $shippingfee }}">
                <div class="row">
                    @include(config('constant.site_view').'layouts.shippingInfo')
                </div>
                <h4>Phương thức thanh toán</h4>
                <div class="form-group">
                    <label> <input type="radio" name="payment_method" checked="" value="0"> Thanh toán khi giao hàng (COD) </label>
                    <div></div>
                </div>
                <div class="form-group">
                    <label> <input type="radio" name="payment_method" value="1"> Chuyển khoản qua ngân hàng </label>
                    <div class="bank-info">STK: 060239274024<br>Chủ TK: Nguyễn Võ Quốc Huy<br>Ngân hàng: Sacombank TP.HCM <br>
                        Lưu ý: Quý khách hàng vui lòng ghi chú chuyển khoản là <strong>Họ tên + Số điện thoại + Mã đơn hàng</strong>, sau đó chụp hình gửi lại cho shop để shop xác nhận đơn hàng nhanh chóng hơn ạ
                    </div>
                </div>
                <input id="submit" type="submit" class="hidden"/>
            </form>
        </div>
    </div>
@endsection