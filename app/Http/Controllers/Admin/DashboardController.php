<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conds = [];

        $durationStr = request()->input('duration') ?? 'all';
        
        if(in_array($durationStr, ["today", "yesterday", "this-week", "this-month", "three-months", "this-year", "custom"])){
            $duration = $this->getDuration($durationStr);
            array_push($conds, ['created_date', '>=', $duration['from']]);
            array_push($conds, ['created_date', '<=', $duration['to']]);
        }

        $orders = Order::where($conds)->with(['customer', 'staff', 'ward', 'status', 'ward.district', 'ward.district.province'])->get();
        // dd($orders);
        $data = [
            "orders" => $orders,
            "duration" => $durationStr
        ];
        return view('admin.dashboard.index', $data);
    }

    public function getDuration($durationStr){
        $duration = array();
        switch($durationStr){
            case 'today':
                $duration["from"] = date("Y-m-d 00:00:00");
                $duration["to"] = date("Y-m-d 23:59:59");
                break;
            case 'yesterday':
                $duration["from"] = date('Y-m-d 00:00:00',strtotime("-1 days"));
                $duration["to"] = date('Y-m-d 23:59:59',strtotime("-1 days"));
                break;
            case 'this-week':
                $duration["from"] = date('Y-m-d 00:00:00', strtotime('-'. date('w') .' days'));
                $duration["to"] = date("Y-m-d 23:59:59");
                break;
            case 'this-month':
                $duration["from"] = date('Y-m-d 00:00:00', strtotime("first day of this month"));
                $duration["to"] = date("Y-m-d 23:59:59");
                break;
            case 'three-months':
                $duration["from"] = date('Y-m-d 00:00:00', strtotime("first day of -3 month"));
                $duration["to"] = date("Y-m-d 23:59:59");
                break;
            case 'this-year':
                $duration["from"] = date('Y-01-01 00:00:00');
                $duration["to"] = date("Y-m-d 23:59:59");
                break;
            case 'custom':
                $duration["from"] = request()->from_date;
                $duration["to"] = request()->to_date;
                break;
            default:
                break;
        }
        return $duration;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
