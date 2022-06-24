@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Quản lý</a>
            </li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
        <!-- DataTables Example -->
        <div class="action-bar">
            <input type="submit" class="btn btn-primary btn-sm" value="Thêm" name="add">
            <input type="submit" class="btn btn-danger btn-sm" value="Xóa" name="delete">
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onclick="checkAll(this)"></th>
                                <th>Mã</th>
                                <th style="width:50px">Tên</th>
                                <th>Hình ảnh</th>
                                <th>Giá bán lẻ</th>
                                <th>% giảm giá</th>
                                <th>Giá bán thực tế</th>
                                <th>Lượng tồn</th>
                                <th>Đánh giá</th>
                                <th>Nội bật</th>
                                <th>Thương hiệu</th>
                                <th>Danh mục</th>
                                <th>Ngày tạo</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>#{{ $product->id }}</td>
                                    <td style="min-width: 200px;">{{ $product->name }}</td>
                                    <td>
                                        <img src="{{ asset('') }}images/{{ $product->featured_image }}">
                                    </td>
                                    <td>{{ number_format($product->price) }} ₫</td>
                                    <td>{{ $product->discount_percentage ?? 0 }}%</td>
                                    <td>{{ number_format($product->sale_price) }} ₫</td>
                                    <td>{{ $product->inventory_qty }}</td>
                                    <td>{{ $product->star }}</td>
                                    <td>
                                        <input type="checkbox" {{ $product->featured == 1 ? "checked" : "" }} disabled>
                                    </td>
                                    <td>{{ $product->brand->name ?? "" }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->created_date }}</td>
                                    <td>
                                        <a style="min-width: 80px;" class="btn btn-sm btn-info" href="../../pages/comment/list.html">Đánh giá</a>
                                    </td>
                                    <td>
                                        <a style="min-width: 80px;" class="btn btn-sm btn-primary" href="../../pages/image/list.html">Hình ảnh</a>
                                    </td>
                                    <td>
                                        <input type="button" onclick="Edit('25');" value="Sửa" class="btn btn-warning btn-sm">
                                    </td>
                                    <td>
                                        <input type="button" onclick="Delete('25');" value="Xóa" class="btn btn-danger btn-sm">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection