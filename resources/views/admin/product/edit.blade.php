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
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-md-12 control-label" for="barcode">Barcode</label>  
                <div class="col-md-9 col-lg-6">
                   <input name="barcode" id="barcode" type="text" value="{{ $product->barcode }}" class="form-control">
                </div>
            </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="sku">SKU</label>  
                    <div class="col-md-9 col-lg-6">
                        <input name="sku" id="sku" type="text" value="{{ $product->sku }}" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-12 control-label" for="name">Tên</label>
                    <div class="col-md-9 col-lg-6">
                        <input name="name" id="name" type="text" value="{{ $product->name }} " class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="featured_image">Ảnh nổi bật</label>
                    <div class="col-md-12 my-3">
                        <img style="width: 150px;" src="{{ $product->featured_image }}" alt="{{ $product->name }}">
                    </div>
                    <div class="col-md-9 col-lg-6">
                        <input type="file" name="featured_image" id="image" class="d-none">
                        <label for="image" class="btn btn-info rounded-0">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Chọn ảnh
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="image_item">Thumnail</label>
                    <div class="col-md-12 my-3">
                        <div class="gallery row">
                            
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-6">
                        <input type="file" name="image_item[]" id="image_item" class="upload_image d-none" multiple>
                        <label for="image_item">
                            <i class="fas fa-upload"></i>
                            Chọn ảnh
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="retail-price">Giá</label>  
                    <div class="col-md-9 col-lg-6">
                        <input name="retail-price" id="retail-price" type="text" value="<?=$product->getPrice()?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="discount-percent">% giảm giá</label>  
                    <div class="col-md-9 col-lg-6">
                        <input name="discount-percent" id="discount-percent" type="text" value="<?=$product->getDiscountPercentage()?>" class="form-control">  
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="discount-from">Giảm giá từ ngày</label>  
                    <div class="col-md-9 col-lg-6">
                    <input name="discount-from" id="discount-from" type="date" value="<?=$product->getDiscountFromDate()?>" class="form-control">  
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="discount-to">Giảm giá đến ngày</label>  
                    <div class="col-md-9 col-lg-6">
                        <input name="discount-to" id="discount-to" type="date" value="<?=$product->getDiscountToDate()?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="sale_price">Giá bán thực tế</label>  
                    <div class="col-md-9 col-lg-6">
                        <input name="sale_price" id="sale_price" type="text" value="<?=$product->getSalePrice()?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="inventory-number">Lượng tồn</label>
                    <div class="col-md-9 col-lg-6">
                        <input name="inventory-number" id="inventory-number" type="text" value="<?=$product->getInventoryQty()?>" class="form-control">			
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="comment">Đánh giá</label>
                    <div class="col-md-9 col-lg-6">
                        <input name="comment" id="comment" type="text" value="<?=$product->getStar()?>" class="form-control" readonly>         
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="category">Danh mục</label>  
                    <div class="col-md-9 col-lg-6">
                        <select name="category" id="category" class="form-control">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?=$category->getId()?>" <?=$category->getId() == $product->getCategoryId() ? 'selected' : null?>>
                                    <?=$category->getName()?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="brand">Thương hiệu</label>  
                    <div class="col-md-9 col-lg-6">
                        <select name="brand" id="brand" class="form-control">
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?=$brand->getId()?>" <?=$brand->getId() == $product->getBrandId() ? 'selected' : null?>>
                                    <?=$brand->getName()?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label">Ngày tạo</label>  
                    <div class="col-md-9 col-lg-6">
                        <?=$product->getCreatedDate()?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="featured">Nổi bật</label>  
                    <div class="col-md-9 col-lg-6">
                        <input type="checkbox" value="1" <?=$product->getFeatured() == 1 ? 'checked' : null?> name="featured" id="featured">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="description">Mô tả</label>  
                    <div class="col-md-12">
                        <textarea name="description" id="description" rows="10" cols="80">
                            <?=$product->getDescription()?>
                        </textarea>
                    </div>
                </div>
                <div class="form-action mb-3">
                    <input type="submit" class="btn btn-primary btn-sm" value="Cập nhật">
                </div>
        </form>
        <script type="text/javascript" src="{{ asset('') }}adm/vendor/ckeditor/ckeditor.js"></script>
        <script>CKEDITOR.replace('description');</script>
        <!-- /form -->
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
@endsection