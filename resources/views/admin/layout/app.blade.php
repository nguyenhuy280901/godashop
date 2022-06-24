<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tổng quan</title>
    <!-- Create favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}favicon.ico" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('') }}/adm/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="{{ asset('') }}/adm/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('') }}/adm/css/sb-admin.css" rel="stylesheet">
    <link href="{{ asset('') }}/adm/css/admin.css" rel="stylesheet">
</head>
<body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">Mỹ Phẩm YouT</a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search -->
        <!-- Navbar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item no-arrow text-white">
                <span>Chào {{ Auth::guard('admin')->user()->name }}</span> |
                <a class="text-white nounderline" href="{{ route('admin.logout') }}" data-toggle="modal"
                    data-target="#logoutModal">Thoát</a>
            </li>
        </ul>
    </nav>
    <div id="wrapper">
        @php
            $currentRouteName = Route::currentRouteName();
        @endphp
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item {{ $currentRouteName == "dashboard" ? "active" : "" }}">
                <a class="nav-link" href="{{ route("dashboard") }}"><i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tổng quan</span></a>
            </li>
            <li class="nav-item dropdown {{ in_array($currentRouteName, ["admin.order.index", "admin.order.create"]) ? "active show" : "" }}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-shopping-cart"></i> <span>Đơn hàng</span></a>
                <div class="dropdown-menu {{ in_array($currentRouteName, ["admin.order.index", "admin.order.create"]) ? "show" : "" }}" aria-labelledby="">
                    <a class="dropdown-item {{ in_array($currentRouteName, ["admin.order.index"]) ? "active" : "" }}" href="{{ route('admin.order.index') }}">Danh sách</a>
                    <a class="dropdown-item {{ in_array($currentRouteName, ["admin.order.create"]) ? "active" : "" }}" href="{{ route('admin.order.create') }}">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown {{ in_array($currentRouteName, ["admin.product.index", "admin.product.create"]) ? "active show" : "" }}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="">
                    <i class="fab fa-product-hunt"></i>
                    <span>Sản phẩm</span>
                </a>
                <div class="dropdown-menu {{ in_array($currentRouteName, ["admin.product.index", "admin.product.create"]) ? "show" : "" }}" aria-labelledby="">
                    <a class="dropdown-item {{ in_array($currentRouteName, ["admin.product.index"]) ? "active" : "" }}" href="{{ route('admin.product.index') }}">Danh sách</a>
                    <a class="dropdown-item {{ in_array($currentRouteName, ["admin.product.create"]) ? "active" : "" }}" href="{{ route('admin.product.create') }}">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-comments"></i> <span>Comment</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/comment/list.html">Danh sách</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i class="far fa-image"></i>
                    <span>Hình ảnh</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/image/list.html">Danh sách</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-user-alt"></i> <span>Khách hàng</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/customer/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/customer/add.html">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown {{ in_array($currentRouteName, ["admin.category.index", "admin.category.create"]) ? "active show" : "" }}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i class="fas fa-folder"></i>
                    <span>Danh mục</span></a>
                <div class="dropdown-menu {{ in_array($currentRouteName, ["admin.category.index", "admin.category.create"]) ? "show" : "" }}" aria-labelledby="">
                    <a class="dropdown-item {{ in_array($currentRouteName, ["admin.category.index"]) ? "active" : "" }}" href="{{ route('admin.category.index') }}">Danh sách</a>
                    <a class="dropdown-item {{ in_array($currentRouteName, ["admin.category.create"]) ? "active" : "" }}" href="{{ route('admin.category.create') }}">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-percentage"></i> <span>Khuyến mãi</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/promotion/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/promotion/add.html">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-shipping-fast"></i> <span>Phí giao hàng</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/transport/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/transport/add.html">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i class="fas fa-users"></i>
                    <span>Nhân viên</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/staff/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/staff/add.html">Thêm</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-user-shield"></i> <span>Phân quyền</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/permission/roles.html">Danh sách vai trò</a>
                    <a class="dropdown-item" href="../../pages/permission/add_role.html">Thêm vai trò</a>
                    <a class="dropdown-item" href="../../pages/permission/actions.html">Danh sách tác vụ</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../pages/order_status/list.html"><i class="fas fa-star-half-alt"></i>
                    <span>Trạng thái đơn hàng</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id=""><i
                        class="fas fa-file-alt"></i> <span>News letter</span></a>
                <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="../../pages/newsletter/list.html">Danh sách</a>
                    <a class="dropdown-item" href="../../pages/newsletter/send.html">Gửi mail</a>
                </div>
            </li>
        </ul>
        <div id="content-wrapper">
            <input type="hidden" name="" id="reference" value="{{ env('APP_URL') }}">
            @include('admin.layout.message')
            @yield('content')
            <!-- /.content-wrapper -->
            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Thầy Lộc 2017</span>
                    </div>
                </div>
            </footer>
        </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn muốn thoát?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>

                    <a class="btn btn-primary" href="javascript:void()" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                        Thoát
                    </a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('') }}/adm/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('') }}/adm/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('') }}/adm/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('') }}/adm/vendor/datatables/jquery.dataTables.js"></script>
    <script src="{{ asset('') }}/adm/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('') }}/adm/js/sb-admin.min.js"></script>
    <!-- Demo scripts for this page-->
    <script src="{{ asset('') }}/adm/js/demo/datatables-demo.js"></script>
    <script src="{{ asset('') }}/adm/js/admin.js"></script>
</body>
</html>