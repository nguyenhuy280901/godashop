@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Tổng quan</li>
        </ol>
        <div class="mb-3 my-3">
            <a href="{{ request()->fullUrlWithQuery(['duration' => 'all', 'from_date' => null, 'to_date' => null]) }}" class="{{ $duration == 'all' ? 'active' : '' }} btn btn-primary">Tất cả</a>
            <a href="{{ request()->fullUrlWithQuery(['duration' => 'today', 'from_date' => null, 'to_date' => null]) }}" class="{{ $duration == 'today' ? 'active' : '' }} btn btn-primary">Hôm nay</a>
            <a href="{{ request()->fullUrlWithQuery(['duration' => 'yesterday', 'from_date' => null, 'to_date' => null]) }}" class="{{ $duration == 'yesterday' ? 'active' : '' }} btn btn-primary">Hôm qua</a>
            <a href="{{ request()->fullUrlWithQuery(['duration' => 'this-week', 'from_date' => null, 'to_date' => null]) }}" class="{{ $duration == 'this-week' ? 'active' : '' }} btn btn-primary">Tuần này</a>
            <a href="{{ request()->fullUrlWithQuery(['duration' => 'this-month', 'from_date' => null, 'to_date' => null]) }}" class="{{ $duration == 'this-month' ? 'active' : '' }} btn btn-primary">Tháng này</a>
            <a href="{{ request()->fullUrlWithQuery(['duration' => 'three-months', 'from_date' => null, 'to_date' => null]) }}" class="{{ $duration == 'three-months' ? 'active' : '' }} btn btn-primary">3 tháng</a>
            <a href="{{request()->fullUrlWithQuery(['duration' => 'this-year', 'from_date' => null, 'to_date' => null])}}" class="{{ $duration == 'this-year' ? 'active' : '' }} btn btn-primary">Năm này</a>
            <div class="dropdown" style="display:inline-block">
                <a class="btn btn-primary dropdown-toggle {{ $duration == 'custom' ? 'active' : '' }}" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <div style="margin:20px">
                        <form action="{{ route('dashboard') }}" method="GET">
                            <input type="hidden" name="duration" value="custom">
                            Từ ngày <input type="date" name="from_date" class="form-control">
                            Đến ngày <input type="date" name="to_date" class="form-control">
                            <br>
                            <input type="submit" value="Tìm" class="btn btn-primary form-control">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Icon Cards-->
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-list"></i>
                    </div>
                    <div class="mr-5">{{ $orders->count() }} Đơn hàng</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="#">
                    <span class="float-left">Chi tiết</span>
                    <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                    </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                    </div>
                    <div class="mr-5">Doanh thu {{ number_format($orders->whereNotIn('order_status_id', 6)->sum('payment_total')) }}đ</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="#">
                    <span class="float-left">Chi tiết</span>
                    <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                    </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-life-ring"></i>
                    </div>
                    <div class="mr-5">{{ number_format($orders->where('order_status_id', 6)->count()) }} đơn hàng bị hủy</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="#">
                    <span class="float-left">Chi tiết</span>
                    <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Đơn hàng
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('admin.layout.listOrder')
                </div>
            </div>
        </div>
    </div>
@endsection