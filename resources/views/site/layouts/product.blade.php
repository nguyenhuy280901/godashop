<div class="product-container">
    <div class="image">
        <img class="img-responsive" src="{{ asset('') }}images/{{ $product->featured_image }}" alt="{{ $product->name }}">
    </div>
    <div class="product-meta">
        <h5 class="name">
            <a class="product-name" href="{{ route('product.show', ['product' => $product->id]) }}" title="{{ $product->name }}">{{ $product->name }}</a>
        </h5>
        <div class="product-item-price">
            @if($product->price != $product->sale_price)
                <span class="product-item-regular">{{ number_format($product->price) }}₫</span>
            @endif
            <span class="product-item-discount">{{ number_format($product->sale_price) }}đ</span>            
        </div>
    </div>
    <div class="button-product-action clearfix">
        <div class="cart icon">
            <a href="javascipt:void(0)" class="btn btn-outline-inverse buy {{ $product->inventory_qty == 0 ? "disabled" : "" }}" product-id="{{ $product->id }}" title="Thêm vào giỏ">
                {{ $product->inventory_qty == 0 ? "Đã hết hàng" : "Thêm vào giỏ" }}
                 <i class="fa fa-shopping-cart"></i>
            </a>
        </div>
        <div class="quickview icon">
            <a class="btn btn-outline-inverse" href="{{ route('product.show', ['product' => $product->id]) }}" title="Xem nhanh">
            Xem chi tiết <i class="fa fa-eye"></i>
            </a>
        </div>
    </div>
</div>