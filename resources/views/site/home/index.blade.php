@extends(config('constant.site_view').'layouts.app', ['title' => 'Trang chủ'])

@section('content')
    @foreach($categories as $category)
        @php
            $products = $category->products->sortBy('created_date')->reverse();
        @endphp
        @if ($products->count() > 0)
            <div class="row equal">
                <div class="col-xs-12">
                    <h4 class="home-title">{{ $category->name }}</h4>
                </div>
                @foreach($products as $product)
                    <div class="col-xs-6 col-sm-3">
                        @include(config('constant.site_view').'layouts.product')
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
@endsection