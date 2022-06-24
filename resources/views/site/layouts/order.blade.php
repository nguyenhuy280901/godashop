@php
    $orderItems = $order->orderItems;
@endphp

<div class="row">
    <div class="col-md-12">
        <h5>Đơn hàng <a href="{{ route('order.show', ["order" => $order->id]) }}">#{{ $order->id }}</a></h5>
        <p class="date">
            Ngày Đặt hàng: {{ $order->created_date }}
        </p>
        <p class="date">
            Ngày giao hàng dự kiến: {{ $order->delivered_date }}
        </p>
        <p class="date">
            Tổng trị giá: <strong class="price">{{ number_format($order->payment_total) . " VNĐ" }}</strong>
        </p>
        <p class="date">
            Trạng thái: {{ $order->status->description }}
        </p>
        <hr>
        @foreach($orderItems as $orderItem)
            @include(config('constant.site_view').'layouts.orderItem')
        @endforeach
    </div>
</div>