<div class="form-group col-sm-6">
    <input type="text" value="{{ isset($customer) ? $customer->shipping_name : "" }}" class="form-control" name="fullname" placeholder="Họ và tên" required oninvalid="this.setCustomValidity('Vui lòng nhập tên của bạn')" oninput="this.setCustomValidity('')">
</div>
<div class="form-group col-sm-6">
    <input type="tel" value="{{ isset($customer) ? $customer->shipping_mobile : "" }}" class="form-control" name="mobile" placeholder="Số điện thoại" required pattern="[0][0-9]{9,}" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại bắt đầu bằng số 0 và ít nhất 9 con số theo sau')" oninput="this.setCustomValidity('')">
</div>
<div class="form-group col-sm-4">
    <select name="province" class="form-control province" required oninvalid="this.setCustomValidity('Vui lòng chọn Tỉnh / thành phố')" oninput="this.setCustomValidity('')">
        <option value="">Tỉnh / thành phố</option>
        @foreach ($provinces as $province)
            <option {{ isset($customer->ward_id) && $province->id == $customer_province->id ? "selected" : "" }} value="{{ $province->id }}">{{ $province->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-4">
    <select name="district" class="form-control district" required oninvalid="this.setCustomValidity('Vui lòng chọn Quận / huyện')" oninput="this.setCustomValidity('')">
        <option value="">Quận / huyện</option>
        @if(isset($customer->ward_id))
            @foreach ($customer_province->districts as $district)
                <option {{ $district->id == $customer_district->id ? "selected" : "" }} value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="form-group col-sm-4">
    <select name="ward" class="form-control ward" required="" oninvalid="this.setCustomValidity('Vui lòng chọn Phường / xã')" oninput="this.setCustomValidity('')">
        <option value="">Phường / xã</option>
        @if(isset($customer->ward_id))
            @foreach ($customer_district->wards as $ward)
                <option {{ $ward->id == $customer->ward_id ? "selected" : "" }} value="{{ $ward->id }}">{{ $ward->name }}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="form-group col-sm-12">
    <input type="text" value="{{ isset($customer) ?  $customer->housenumber_street : "" }}" class="form-control" placeholder="Địa chỉ" name="housenumber_street" required oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ bao gồm số nhà, tên đường')" oninput="this.setCustomValidity('')">
</div>