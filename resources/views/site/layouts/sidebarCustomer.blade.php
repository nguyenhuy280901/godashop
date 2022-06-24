<div class="col-xs-9">
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
        <li><span>/</span></li>
        <li class="active"><span>Tài khoản</span></li>
    </ol>
</div>
<div class="clearfix"></div>
<aside class="col-md-3">
    <div class="inner-aside">
        <div class="category">
            <ul>
                <li class="{{ Route::currentRouteName() == 'customer.info.show' ? "active" : "" }}">
                    <a href="{{ route('customer.info.show') }}" title="Thông tin tài khoản" target="_self">Thông tin tài khoản
                    </a>
                </li>
                <li class="{{ Route::currentRouteName() == 'customer.shipping.show' ? "active" : "" }}">
                    <a href="{{ route('customer.shipping.show') }}" title="Địa chỉ giao hàng mặc định" target="_self">Địa chỉ giao hàng mặc định
                    </a>
                </li>
                <li class="{{ Route::currentRouteName() == 'customer.order.list' ? "active" : "" }} || {{ Route::currentRouteName() == 'order.show' ? "active" : "" }}">
                    <a href="{{ route('customer.order.list') }}" target="_self">Đơn hàng của tôi
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>