<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine_detail;
use App\Models\User;
use App\Models\Order;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;

class pctoolController extends Controller
{
    public function view(Request $request){
        $data = [
            'records' => Machine_detail::all(),
            'user' => Auth::user(),
            'input' => $request,
            'inUse' => $request->session()->get('inUse')

        ];
        // dd($data);
        return view('pctool', $data);
    }
    //
    public function detail(Request $request){
        $id= $request->id;
        $data = [
            'machine_details' => Machine_detail::find($id),
            'orders' => Order::join('machine_detail_order','orders.order_id','=','machine_detail_order.order_id')
                ->join('machine_details','machine_detail_order.machine_id','=','machine_details.machine_id')
                ->where('machine_details.machine_id',$id)
                ->get(),
            'maintenances' => Maintenance::where('machine_id',$id)->get()
        ];
        return view('detail', $data);
    }
    public function error(Request $request){
        // $data = [
        //     'records' => Machine_detail::all(),
        //     'user' => Auth::user(),
        //     'input' => $request,
        //     'inUse' => implode(',',$request->session()->get('inUse')),
        // ];
        $request->session()->reflash();
        return back()->withInput();
    }

}
