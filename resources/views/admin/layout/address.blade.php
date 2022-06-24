@php
    $selected_ward = $order->ward ?? null;
    $selected_district = $selected_ward->district ?? null;
    $selected_province = $selected_district->province ?? null;
    
    $districts = $selected_province->districts ?? null;
    $wards = $selected_district->wards ?? null;
@endphp
<div class="row">
    <div class="col-sm-4 col-lg-2">
        <label>Địa chỉ giao hàng</label>  
    </div>
    <div class="col-sm-8 col-lg-6"> 
        <div class="row">
            <div class="col-sm-4">
                <select name="province" class="form-control province" required=""
                        oninvalid="this.setCustomValidity('Vui lòng chọn Tỉnh / thành phố')"
                        oninput="this.setCustomValidity('')">
                    <option value="">Tỉnh / thành phố</option>
                    @foreach ($provinces as $province)
                        <option {{ !empty($selected_province) && $province->id == $selected_province->id ? 'selected' : '' }}
                            value="{{ $province->id }}">
                            {{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <select name="district" class="form-control district" required=""
                    oninvalid="this.setCustomValidity('Vui lòng chọn Quận / huyện')"
                    oninput="this.setCustomValidity('')">
                    <option value="">Quận / huyện</option>
                    @if(!empty($districts))
                        @foreach ($districts as $district)
                            <option {{ $district->id == $selected_district->id ? 'selected' : '' }}
                                value="{{ $district->id }}">
                                {{ $district->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-4">
                <select name="ward" class="form-control ward" required=""
                    oninvalid="this.setCustomValidity('Vui lòng chọn Phường / xã')"
                    oninput="this.setCustomValidity('')">
                    <option value="">Phường / xã</option>
                    @if(!empty($wards))
                        @foreach ($wards as $ward)
                            <option {{ $ward->id == $selected_ward->id ? 'selected' : '' }}
                                value="{{ $ward->id }}">
                                {{ $ward->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-12" style="margin-top: 10px;">
                <input type="text" class="form-control" value="{{ !empty($order) ? $order->shipping_housenumber_street : "" }}" name="housenumber_street" placeholder="Số nhà">
            </div>
        </div>
    </div>
</div>