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
        <!-- DataTables Example -->
        <div class="action-bar">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm"> Thêm </a>
            <input type="submit" class="btn btn-danger btn-sm" value="Xóa" name="delete">
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onclick="checkAll(this)"></th>
                                <th>Tên</th>
                                <th>
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('admin.category.edit', ['category' => $category->id]) }}">Sửa</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.category.destroy', ["category" => $category->id]) }}" method="POST">
                                            @csrf
                                            @method("delete")
                                            <input type="submit" onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này?');" value="Xóa" class="btn btn-danger btn-sm">
                                        </form>
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
