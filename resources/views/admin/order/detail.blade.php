@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Quản lý</a>
            </li>
            <li class="breadcrumb-item active">Đơn hàng</li>
        </ol>
        <!-- /.row -->
        @php
            $customer = $order->customer;
        @endphp
        <div class="row">
            <div class="col-sm-12 ">
                <label for="name" class="control-label">Đơn hàng: #{{ $order->id }}</label>
                <input type="hidden" name="id" value="{{ $order->id }}">
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-4 col-lg-2">
                <label>Tên khách hàng:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ $customer->name }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Điện thoại:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ $customer->mobile }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Email:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ $customer->email }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Trạng thái:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ $order->status->description }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Ngày đặt hàng:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ $order->delivered_date }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Hình thức giao hàng:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>Giao Hàng Tiêu Chuẩn: Từ 2 đến 3 ngày</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Phí giao hàng:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ number_format($order->shipping_fee) }} đ</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Tạm tính:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ number_format($order->sub_total) }} đ</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Tổng cộng:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ number_format($order->payment_total) }} đ đ</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Địa chỉ giao hàng:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ $order->shipping_housenumber_street }}, {{ $order->ward->name }},
                    {{ $order->ward->district->name }},
                    {{ $order->ward->district->province->name }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-lg-2">
                <label>Nhân viên phụ trách:</label>
            </div>
            <div class="col-sm-8 col-lg-10">
                <span>{{ $order->staff->name ?? "" }}</span>
            </div>
        </div>
        <label class="control-label">Sản phẩm</label>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                @php
                                    $product = $item->product;
                                @endphp
                                <tr>
                                    <td>#{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td><img src="{{ asset('') }}/images/{{ $product->featured_image }}"></td>
                                    <td>{{ number_format($product->price) }}đ
                                        @if ($product->sale_price != $product->price)
                                            <br><del>{{ number_format($product->sale_price) }} đ
                                            </del><br><del>{{ $product->discount_percentage }}%</del>
                                        @endif
                                    </td>

                                    <td>{{ $item->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection
