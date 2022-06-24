<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Transport;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Get the list of districts by province id
     * @return \Illuminate\Http\Response
     */
    public function getDistricts($id){
        $province = Province::find($id);
        return json_encode($province->districts);
    }
    
    /**
     * Get the list of wards by district id
     * @return \Illuminate\Http\Response
     */
    public function getWards($id){
        $district = District::find($id);
        return json_encode($district->wards);
    }
    
    /**
     * Get shipping fee by province id
     * @return int
     */
    public function getShippingFee($id){
        try {
            $transport = Transport::where('province_id', $id)->firstOrFail();
            return $transport->price;
        } catch (ModelNotFoundException $e) {
            return 50000;
        }
    }
}
