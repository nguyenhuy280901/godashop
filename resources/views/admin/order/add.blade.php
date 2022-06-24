@extends('admin.layout.app')

@php
    $currentStaff = Auth::guard('admin')->user();
@endphp

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Quản lý</a>
            </li>
            <li class="breadcrumb-item active">Đơn hàng</li>
        </ol>
        <!-- /.row -->
        <form class="spacing" method="POST" action="{{ route('admin.order.store') }}">
            @csrf
            <div class="row">
                <div class="col-sm-4 col-lg-2">
                    <label>Tên khách hàng:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <select name="customer_id" class="form-control" required>
                        <option value="">Chọn khách hàng</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>                  
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Trạng thái:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <select name="order_status_id" class="form-control" required>
                        <option value="">Chọn trạng thái đơn hàng</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Người nhận</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <input type="text" name="shipping_fullname" value="" class="form-control" required>                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Số điện thoại người nhận</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <input type="text" name="shipping_mobile" value="" class="form-control" required>                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Hình thức thanh toán</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <select name="transport" class="form-control" required>
                        <option selected value="0">COD</option>
                        <option value="1">Bank</option>
                    </select>
                </div>
            </div>
            {{-- Include address select --}}
            @include('admin.layout.address')

            <div class="row">
                <div class="col-sm-4 col-lg-2">
                    <label>Ngày giao hàng</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <input type="date" name="delivered_date" value="{{ date('Y-m-d', strtotime("+3 days")) }}" class="form-control" required>
                </div>
            </div>
    
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Nhân viên phụ trách</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <select name="staff_id" class="form-control">
                        <option value="">Chọn nhân viên</option>
                        @foreach ($staffs as $staff)
                            <option {{ $currentStaff->id == $staff->id ? "selected" : "" }} value ="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Tạm tính:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <span class="sub-total" data="0">0 đ</span>              
                </div>
            </div>
                
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Phí giao hàng:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <input name="shipping_fee" class="shipping-fee form-control" type="number" value="" required>         
                </div>
            </div>
        
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Tổng cộng:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <span class="payment-total">0 đ</span>              
                </div>
            </div>

            <label class="control-label">Sản phẩm</label>  
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label for="search-barcode">Nhập barcode: </label>
                </div>
                <div class="col-sm-8 col-lg-6">
                    <input type="number" name="search-barcode" id="search-barcode" class="form-control">
                    <div class="search-result"></div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover product-item" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-action">
                <a href="{{ route('admin.order.index') }}" class="btn btn-secondary btn-sm">Hủy</a>
                <input type="submit" class="btn btn-primary btn-sm" value="Lưu" name="save">
            </div>
            <br>
        </form>
    </div>
@endsection