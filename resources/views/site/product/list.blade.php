@extends(config('constant.site_view').'layouts.app', [
    'title' => 'Danh sách sản phẩm',
    'categories' => $categories,
])

@section('content')
    <div class="row">
        <div class="col-xs-9">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}" target="_self">Trang chủ</a>
                </li>
                <li><span>/</span></li>
                <li class="active"><span>{{ isset($filterCategory) ? $filterCategory->name : (isset($search) ? "Tìm kiếm sản phẩm" : "Tất cả sản phẩm") }}</span></li>
            </ol>
        </div>
        <div class="col-xs-3 hidden-lg hidden-md">
            <a class="hidden-lg pull-right btn-aside-mobile" href="javascript:void(0)">Bộ lọc <i class="fa fa-angle-double-right"></i></a>
        </div>
        <div class="clearfix"></div>
        @include(config('constant.site_view').'layouts.sidebar', [])
        <div class="col-md-9 products">
            <div class="row equal">
                <div class="col-xs-6">
                    <h4 class="home-title">
                        {{ isset($filterCategory) ? $filterCategory->name : (isset($search) ? "Kết quả tìm kiếm: " . $search : "Tất cả sản phẩm") }}
                    </h4>
                </div>
                <div class="col-xs-6 sort-by">
                    <div class="pull-right">
                        <label class="left hidden-xs" for="sort-select">Sắp xếp: </label>
                        <select id="sort-select">
                            <option value="" {{ !isset($sortby) ? "selected" : "" }}>Mặc định</option>
                            <option value="price-asc" {{ isset($sortby) && $sortby == "price-asc" ? "selected" : "" }}>Giá tăng dần</option>
                            <option value="price-desc" {{ isset($sortby) && $sortby == "price-desc" ? "selected" : "" }}>Giá giảm dần</option>
                            <option value="alpha-asc" {{ isset($sortby) && $sortby == "alpha-asc" ? "selected" : "" }}>Từ A-Z</option>
                            <option value="alpha-desc" {{ isset($sortby) && $sortby == "alpha-desc" ? "selected" : "" }}>Từ Z-A</option>
                            <option value="created-asc" {{ isset($sortby) && $sortby == "created-asc" ? "selected" : "" }}>Cũ đến mới</option>
                            <option value="created-desc" {{ isset($sortby) && $sortby == "created-desc" ? "selected" : "" }}>Mới đến cũ</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                @foreach ($products as $product)
                    <div class="col-xs-6 col-sm-4">
                        @include(config('constant.site_view').'layouts.product')
                    </div>
                @endforeach
            </div>
            <!-- Paging -->
            <div class="pull-right">
                {!! $products->render() !!}
            </div>
            <!-- End paging -->
        </div>
    </div>
@endsection
