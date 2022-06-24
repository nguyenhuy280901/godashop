@extends('admin.layout.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Quản lý</a>
            </li>
            <li class="breadcrumb-item active">Danh mục</li>
        </ol>
        <!-- /form -->
        <form method="post" action="{{ route('admin.category.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-md-12 control-label" for="name">Tên</label>
                <div class="col-md-9 col-lg-6">
                    <input name="name" id="name" type="text" class="form-control">
                </div>
            </div>
            <div class="form-action">
                <input type="submit" class="btn btn-primary btn-sm" value="Lưu" name="save">
            </div>
        </form>
        <!-- /form -->
    </div>
@endsection
