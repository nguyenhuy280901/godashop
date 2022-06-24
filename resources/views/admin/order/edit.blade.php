@extends('admin.layout.app')

@php
    $customer = $order->customer;
    $order_status = $order->status;
    $order_staff = $order->staff;
@endphp

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                    Đơn hàng
            </li>
            <li class="breadcrumb-item active">
                    <a href="javascript:void(0)">Sửa đơn hàng</a>
            </li>
        </ol>
        <!-- /.row -->
        <form class="spacing" method="post" action="{{ route('admin.order.update', ['order' => $order->id]) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-12 ">
                    <label for="name" class="control-label">
                        <a href="{{ route('admin.order.show', ['order' => $order->id]) }}">Đơn hàng: #{{ $order->id }}</a>
                    </label>
                    <input type="hidden" name="id" value="{{ $order->id }}">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2">
                    <label>Tên khách hàng:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <span>{{ $customer->name }}</span>						
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Email:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <span>{{ $customer->email }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Trạng thái:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <select name="order_status_id" class="form-control">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ $status->id == $order_status->id ? "selected" : "" }} >{{ $status->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2">
                    <label>Ngày đặt hàng:</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <span>{{ $order->created_date }}</span>							
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Người nhận</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <input type="text" name="shipping_fullname" value="{{ $order->shipping_fullname }}" class="form-control"> 							
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Số điện thoại người nhận</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <input type="text" name="shipping_mobile" value="{{ $order->shipping_mobile }}" class="form-control"> 							
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Hình thức thanh toán</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <select name="payment_method" class="form-control">
                        <option value="0" {{ $order->payment_method == 0 ? "selected" : "" }}>COD</option>
                        <option value="1" {{ $order->payment_method == 1 ? "selected" : "" }}>Bank</option>
                    </select>
                </div>
            </div>
            @include('admin.layout.address')
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Ngày giao hàng</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <input type="date" name="delivered_date" value="{{ $order->delivered_date }}" class="form-control">
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Nhân viên phụ trách</label>  
                </div>
                <div class="col-sm-8 col-lg-6"> 
                    <select name="staff_id" class="form-control">
                        <option>Vui lòng chọn nhân viên</option>
                        @foreach ($staffs as $staff)
                            <option value="{{ $staff->id }}" {{ !empty($order_staff) && $staff->id == $order_staff->id ? "selected" : "" }} >{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Tạm tính</label>  
                </div>
                <div class="col-sm-8 col-lg-6 sub-total" data="{{ $order->sub_total }}"> 
                    {{ number_format($order->sub_total) }} đ
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Phí giao hàng</label>  
                </div>
                <div class="col-sm-8 col-lg-6">
                    <input type="number" class="form-control shipping-fee" name="shipping-fee" value="{{ $order->shipping_fee }}">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-lg-2 ">
                    <label>Tổng cộng</label>  
                </div>
                <div class="col-sm-8 col-lg-6 payment-total">
                    {{ number_format($order->payment_total) }} đ
                </div>
            </div>

            <label class="control-label">Sản phẩm</label>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                               <tr>
                                   <th><input type="checkbox" onclick="checkAll(this)"></th>
                                  <th>Mã sản phẩm</th>
                                  <th>Tên sản phẩm</th>
                                  <th>Hình ảnh</th>
                                  <th>Giá</th>
                                  <th>Số lượng</th>
                                  <th>Thành tiền</th>
                               </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    @php
                                        $product = $item->product;
                                    @endphp
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td >#{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <img src="{{ asset('') }}images/{{ $product->featured_image }}">
                                        </td>
                                        <td>
                                            {{ number_format($product->sale_price) }} đ
                                            @if($product->sale_price != $product->price)
                                                @php
                                                    $price = $item->product->price;
                                                    $sale_price = $item->product->sale_price;
                                                    $discountPercentage = (($price - $sale_price) * 100) / $sale_price;
                                                @endphp
                                                <br><del>{{ number_format($item->product->sale_price) }} đ
                                                </del><br><del>{{ $discountPercentage }}%</del>
                                            @endif
                                        </td>
                                        <td>
                                            <span>{{ $item->qty }}</span>
                                        </td>
                                        <td>
                                            <span>{{ number_format($item->total_price) }} đ</span>
                                        </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="form-action">
                <a href="{{ route('admin.order.index') }}" class="btn btn-info btn-sm">Hủy</a>
                <label for="submit-delete" class="btn btn-danger btn-sm mb-0">Xóa đơn hàng</label>
                <input type="submit" class="btn btn-primary btn-sm" value="Cập nhật" name="update">
                <a href="{{ route('admin.order.show', ["order" => $order->id]) }}" class="btn btn-info btn-sm">Chi tiết đơn hàng</a>
            </div>
            <br>
        </form>
    </div>
    <form action="{{ route('admin.order.destroy', ["order" => $order->id]) }}" method="POST" class="d-none">
        @method("delete")
        @csrf
        <input type="submit" id="submit-delete"/>
    </form>
@endsection
