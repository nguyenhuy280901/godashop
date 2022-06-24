<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mã</th>
            <th>Tên khách hàng</th>
            <th>Điện thoại</th>
            <th>Email</th>
            <th>Trạng Thái</th>
            <th>Ngày đặt hàng</th>
            <th>PTTT</th>
            <th>Người nhận</th>
            <th>SĐT nhận</th>
            <th>Ngày giao hàng</th>
            <th>Phí giao hàng</th>
            <th>Tạm tính</th>
            <th>Thuế</th>
            <th>Tổng cộng</th>
            <th>Địa chỉ giao hàng</th>
            <th>Nhân viên phụ trách</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ $order->customer->mobile }}</td>
                <td>{{ $order->customer->email }}</td>
                <td>{{ $order->status->description }}</td>
                <td>{{ $order->created_date }} </td>
                <td>{{ $order->payment_method == 0 ? 'COD' : 'Bank' }}</td>
                <td>{{ $order->shipping_fullname }}</td>
                <td>{{ $order->shipping_mobile }}</td>
                <td>{{ $order->delivered_date }}</td>
                <td>{{ number_format($order->shipping_fee) }} đ</td>
                <td>{{ number_format($order->sub_total) }} đ</td>
                <td>{{ number_format($order->tax) }} đ</td>
                <td>{{ number_format($order->payment_total) }} đ</td>
                @php
                    $ward = $order->ward;
                    $district = $ward->district;
                    $province = $district->province;
                @endphp
                <td>
                    {{ $order->shipping_housenumber_street }}, {{ $ward->name }},
                    {{ $district->name }},
                    {{ $province->name }}
                </td>
                <td>{{ !empty($order->staff) ? $order->staff->name : '' }} </td>
                <td style="min-width: 80px;">
                    @if ($order->order_status_id != 2 && $order->order_status_id != 6)
                        <a onclick="return confirm('Bạn muốn xác nhận đơn hàng');" class="btn btn-primary btn-sm" href="{{ route('admin.order.confirm', ['order' => $order->id]) }}">
                            Xác nhận
                        </a>
                    @endif
                </td>
                <td> 
                    <a onclick="return confirm('Bạn muốn sửa đơn hàng');" class="btn btn-warning btn-sm"
                        href="{{ route('admin.order.edit', ['order' => $order->id]) }}">
                        Sửa
                    </a>
                </td>
                <td>
                    <form action="{{ route('admin.order.destroy', ["order" => $order->id]) }}" method="POST">
                        @csrf
                        @method("delete")
                        <input type="submit" onclick="return confirm('Bạn chắc chắn muốn đơn hàng này?')" value="Xóa" class="btn btn-danger btn-sm">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>