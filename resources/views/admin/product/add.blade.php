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
        <!-- /form -->
        <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-md-12 control-label" for="barcode">Barcode</label>  
                <div class="col-md-9 col-lg-6">
                   <input name="barcode" id="barcode" type="text" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="sku">SKU</label>  
                <div class="col-md-9 col-lg-6">
                   <input name="sku" id="sku" type="text" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="name">Tên</label>  
                <div class="col-md-9 col-lg-6">
                   <input name="name" id="name" type="text" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="image">Hình ảnh</label>
                <div class="col-md-4 col-lg-3 pr-0">
                    <input class="d-none" type="file" name="featured_image" id="image" required>
                    <label for="image" class="btn btn-info rounded-0">
                        <i class="fas fa-cloud-upload-alt"></i>
                        Chọn ảnh
                    </label>
                </div>
                <div class="col-md-5 col-lg-3">
                    <div class="image-review" style="display: none;">
                        <img src="" class="w-100">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="price">Giá</label>  
                <div class="col-md-9 col-lg-6">
                   <input name="price" id="price" type="text" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="discount-percent">% giảm giá</label>
                <div class="col-md-9 col-lg-6">
                   <input name="discount_percentage" id="discount-percent" type="text" value="" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="discount-from">Giảm giá từ ngày</label>
                <div class="col-md-9 col-lg-6">
                   <input name="discount_from_date" id="discount-from" type="date" value="" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="discount-to">Giảm giá đến ngày</label>
                <div class="col-md-9 col-lg-6">
                   <input name="discount_to_date" id="discount-to" type="date" value="" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="inventory-number">Số lượng tồn kho</label>
                <div class="col-md-9 col-lg-6">
                   <input name="inventory_qty" id="inventory-number" type="text" value="" class="form-control" required>	
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="featured">Nổi bật</label>  
                <div class="col-md-9 col-lg-6">
                   <input name="featured" id="featured" type="checkbox"  value="1">
                </div>
            </div>
             
            <div class="form-group row">
                <label class="col-md-12 control-label" for="category">Danh mục</label>  
                <div class="col-md-9 col-lg-6">
                   <select name="category_id" id="category" class="form-control" required>
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                   </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="category">Thương hiệu</label>  
                <div class="col-md-9 col-lg-6">
                   <select name="brand_id" id="brand" class="form-control">
                        <option value="">Chọn thương hiệu</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                   </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-12 control-label" for="description">Mô tả</label>
                <div class="col-md-12">
                   <textarea name="description" id="description" rows="10" cols="80"></textarea>
                </div>
            </div>
            <div class="form-action mb-3">
                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary btn-sm">Hủy</a>
                <input type="submit" class="btn btn-primary btn-sm" value="Lưu" name="save">
            </div>
        </form>
        <script type="text/javascript" src="{{ asset('') }}adm/vendor/ckeditor/ckeditor.js"></script>
        <script>CKEDITOR.replace('description');</script>
        <!-- /form -->
        <!-- /.container-fluid -->
    </div>
@endsection