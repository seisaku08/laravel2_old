<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineDetail;
use App\Models\Order;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function detail(Request $request){
        $id= $request->id;
        $data = [
            'user' => Auth::user(),
            'machines' => Order::join('machine_detail_order','orders.order_id','=','machine_detail_order.order_id')
                ->join('machine_details','machine_detail_order.machine_id','=','machine_details.machine_id')
                ->where('orders.order_id',$id)
                ->get(),
            'orders' => Order::where('order_id', $id)->first(),
            'maintenances' => Maintenance::where('machine_id',$id)->get()
        ];
        return view('order/detail', $data);
    }
}
