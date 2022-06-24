@extends(config('constant.site_view').'layouts.app', ["title" => "Đơn hàng của tôi"])

@section('content')
    <div class="row">
        @include(config('constant.site_view').'layouts.sidebarCustomer')
        <div class="col-md-9 order">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="home-title">Đơn hàng của tôi</h4>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <!-- Mỗi đơn hàng -->
                    @foreach ($customer->orders as $order)
                        @include(config('constant.site_view').'layouts.order')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection