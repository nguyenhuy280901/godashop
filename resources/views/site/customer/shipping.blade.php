@extends(config('constant.site_view').'layouts.app', ["title" => "Thông tin giao hàng"])

@section('content')
    <div class="row">
        @include(config('constant.site_view').'layouts.sidebarCustomer')
        <div class="col-md-9 account">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="home-title">Địa chỉ giao hàng mặc định</h4>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <form action="{{ route('customer.shipping.update') }}" method="POST" role="form">
                        @csrf
                        <div class="row">
                            @include(config('constant.site_view').'layouts.shippingInfo')
                            <div class="form-group col-sm-12">
                                <button type="submit" class="btn btn-primary pull-right">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection