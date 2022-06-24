@extends(config('constant.site_view').'layouts.app', ['title' => 'Đặt hàng thành công'])

@section('content')
    <div class="col-md-3 hiden-xs"></div>
    <div class="text-center col-md-6 offset-3">
        <img src="{{ asset('') }}images/image-2.gif" alt="suceess">
        <h1 class="text-center text-danger">Đặt hàng thành công!</h1>
        <p style="text-align: justify; text-justify: inter-word; font-size: 18px; font-weight:600;">
            Đơn hàng của quý khách đã hoàn thành. Chúng tôi sẽ liên hệ với quý khách để xác nhận đơn hàng trễ nhất sau 12 giờ tính từ thời gian đặt hàng. Cảm ơn quý khách mua hàng tại Godashop!
        </p>
        <div class="action" style="margin-bottom: 20px;">
            <a class="btn btn-danger btn-md" href="{{ route('order.show', ["order" => $order_id]) }}">Chi tiết đơn hàng</a>
            <a class="btn btn-outline-success btn-md" href="{{ route('product.index') }}">Tiếp tục mua sắm</a>
        </div>
    </div>
@endsection
