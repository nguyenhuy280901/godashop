@extends(config('constant.site_view').'layouts.app', [
    'title' => 'Chi tiết sản phẩm',
    'categories' => $categories,
])

@section('content')
    <div class="row">
        <div class="col-xs-9">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                <li><span>/</span></li>
                <li class="active"><span>{{ $product->category->name }}</span></li>
            </ol>
        </div>
        <div class="col-xs-3 hidden-lg hidden-md">
            <a class="hidden-lg pull-right btn-aside-mobile" href="javascript:void(0)">Bộ lọc <i class="fa fa-angle-double-right"></i></a>
        </div>
        <div class="clearfix"></div>
        @include(config('constant.site_view').'layouts.sidebar')
        <div class="col-md-9 product-detail">
            <div class="row product-info">
                <div class="col-md-6">
                    <img data-zoom-image="{{ asset('') }}images/{{ $product->featured_image }}" class="img-responsive thumbnail main-image-thumbnail" src="{{ asset('') }}images/{{ $product->featured_image }}" alt="">
                    <div class="product-detail-carousel-slider">
                        <div class="owl-carousel owl-theme">
                            @foreach ($product->imageItems as $image)
                                <div class="item thumbnail"><img src="{{ asset('') }}images/{{ $image->name }}" alt=""></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="product-name">{{ $product->name }}</h5>
                    <div class="brand">
                        <span>Nhãn hàng: </span>
                        <span>{{ $product->brand->name ?? "" }}</span> 
                    </div>
                    <div class="product-status"> 
                        <span>Trạng thái: </span>
                        @if($product->inventory_qty == 0)
                            <span class="label-warning">Hết hàng</span>
                        @else
                            <span class="label-success">Còn hàng</span>
                        @endif
                    </div>
                    <div class="product-item-price">
                        <span>Giá: </span>
                        @if ($product->price != $product->sale_price)
                            <span>
                                <del>{{ number_format($product->price) }}</del>
                            </span>
                        @endif
                        <span class="product-item-discount">{{ number_format($product->sale_price) }}₫</span>            
                    </div>
                    <div class="input-group">
                        <input type="number" class="product-quantity form-control" value="1" min="1" max="{{ $product->inventory_qty }}">
                        <a href="javascript:void(0)" product-id="{{ $product->id }}" class="buy-in-detail btn btn-success cart-add-button" {{ $product->inventory_qty == 0 ? "disabled" : "" }} ><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="row product-description">
                <div class="col-xs-12">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#product-description" aria-controls="home" role="tab" data-toggle="tab">Mô tả</a>
                            </li>
                            <li role="presentation">
                                <a href="#product-comment" aria-controls="tab" role="tab" data-toggle="tab">Đánh giá</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="product-description">   
                                {!! $product->description !!}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="product-comment">
                                @guest
                                    <div class="form-group">
                                        <p style="font-size: 16px; margin-bottom: 10px" class="text-danger">Vui lòng đăng nhập để sử dụng chức năng này.</p>
                                        <button class="btn btn-danger btn-login">Đăng nhập</button>
                                    </div>
                                @else
                                    <form class="form-comment" action="{{ route('comment.post') }}" method="GET" role="form">
                                        <label>Đánh giá của bạn</label>
                                        <div class="form-group">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input class="rating-input" name="rating" type="text" title="" value="4"/>
                                            <textarea name="description" id="input" class="form-control" rows="5" required placeholder="Viết đánh giá"></textarea>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Gửi</button>
                                            <div class="loading pull-right">
                                                
                                            </div>
                                        </div>
                                    </form>
                                @endguest
                                <div class="comment-list">
                                    @foreach ($product->comments->sortBy('created_date')->reverse() as $comment)
                                        @include(config('constant.site_view').'comment.comment')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row product-related equal">
                <div class="col-md-12">
                    <h4 class="text-center">Sản phẩm liên quan</h4>
                    <div class="owl-carousel owl-theme">
                        @foreach ($product->category->products->except($product->id) as $product)
                            <div class="item thumbnail">
                                @include(config('constant.site_view').'layouts.product')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection