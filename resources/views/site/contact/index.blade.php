@extends(config('constant.site_view').'layouts.app', ['title' => 'Liên hệ'])

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/" target="_self">Trang chủ</a></li>
                <li><span>/</span></li>
                <li class="active"><span>Liên hệ</span></li> 
            </ol>
        </div>
    </div>
    <div class="row contact">
        <div class="col-md-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d979.7531894552016!2d106.58354538808872!3d10.810334399516304!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752b9db9b6cc6b%3A0x2c470c81478369b7!2zSOG6u20gRDE2LzE3LCBWxKluaCBM4buZYyBCLCBCw6xuaCBDaMOhbmgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1628504189235!5m2!1svi!2s" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="col-md-6">
            <h4>Thông tin liên hệ</h4>
                <form class="form-contact" action="{{ route('contact.sendmail') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname"  placeholder="Họ và tên" required oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn')" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <input type="email" class="form-control" name="email" placeholder="Email" required oninvalid="this.setCustomValidity('Vui lòng nhập email')" oninput="this.setCustomValidity('')">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="tel" class="form-control" name="mobile" placeholder="Số điện thoại" required pattern="[0][0-9]{9,}"
                            oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại bắt đầu bằng số 0 và ít nhất 9 con số theo sau')" oninput="this.setCustomValidity('')">
                        </div>
                        
                        <div class="form-group col-sm-12">
                            <textarea class="form-control" placeholder="Nội dung" name="content" rows="10" required></textarea>
                        </div>
                        <div class="form-group col-sm-12" style="height:80px;">
                            <div id="result" class="col-sm-9" style="padding-left: 0"></div>
                            <button type="submit" class="btn btn-sm btn-primary col-sm-3">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection