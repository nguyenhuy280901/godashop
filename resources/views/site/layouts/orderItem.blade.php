@php
    $product = $orderItem->product;
@endphp

<div class="row">
    <div class="col-md-2">
        <img src="{{ asset('') }}images/{{ $product->featured_image }}" alt="" class="img-responsive">
    </div>
    <div class="col-md-3">
        <a class="product-name" href="{{ route('product.show', ["product" => $product->id]) }}">{{ $product->name }}</a>
    </div>
    <div class="col-md-2">
        Số lượng: {{ $orderItem->qty }}
    </div>
    <div class="col-md-2">
        Giá bán: {{ number_format($orderItem->unit_price) }}
    </div>
    <div class="col-md-3">
        Tổng tiền: {{ number_format($orderItem->total_price) }}
    </div>
</div>