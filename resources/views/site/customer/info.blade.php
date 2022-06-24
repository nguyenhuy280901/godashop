@extends(config('constant.site_view').'layouts.app', ["title" => "Thông tin tài khoản"])

@section('content')
    <div class="row">
        @include(config('constant.site_view').'layouts.sidebarCustomer')
        <div class="col-md-9 account">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="home-title">
                        {{ Route::currentRouteName() == 'customer.info.show' ? "Thông tin tài khoản" : "Cập nhật mật khẩu" }}
                    </h4>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <form class="info-account" action="{{ route('customer.info.update') }}" method="POST" role="form">
                        @csrf
                        <input type="hidden" name="action" value={{  Route::currentRouteName() == 'customer.info.show' ? "update-info" : "reset-password"  }}>
                        @if (Route::currentRouteName() == 'customer.info.show')
                            <div class="form-group">
                                <input type="text" value="{{ $customer->name }}" class="form-control" name="fullname" placeholder="Họ và tên" required oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group">
                                <input type="tel" value="{{ $customer->mobile }}" class="form-control" name="mobile" placeholder="Số điện thoại" required pattern="[0][0-9]{9,}" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại bắt đầu bằng số 0 và ít nhất 9 con số theo sau')" oninput="this.setCustomValidity('')">
                            </div>
                        @endif    
                        @if (Route::currentRouteName() == 'reset-form')
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu mới" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$" oninvalid="this.setCustomValidity('Vui lòng nhập ít nhất 8 ký tự: số, chữ hoa, chữ thường')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="re_password" placeholder="Nhập lại mật khẩu mới" autocomplete="off" autosave="off" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$" oninvalid="this.setCustomValidity('Vui lòng nhập ít nhất 8 ký tự: số, chữ hoa, chữ thường')" oninput="this.setCustomValidity('')">
                            </div>
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection