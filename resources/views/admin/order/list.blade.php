@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Quản lý</a>
            </li>
            <li class="breadcrumb-item active">Đơn hàng</li>
        </ol>
        <!-- DataTables Example -->
        <div class="action-bar">
            <input type="submit" class="btn btn-primary btn-sm" value="Thêm" name="add">
            <input type="submit" class="btn btn-danger btn-sm" value="Xóa" name="delete">
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    @include('admin.layout.listOrder')
                </div>
            </div>
        </div>
    </div>
@endsection
