<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineDetail;
use App\Models\DayMachine;
use App\Models\User;
use App\Models\Order;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use DateTime;

class pctoolController extends Controller
{
    public function view(Request $request){

        $data = [
            'records' => MachineDetail::all(),
            'user' => Auth::user(),
            'input' => $request,
            'inUse' => $request->session()->get('inUse'),

        ];
        if($request->from != ""){
            $from = new DateTime($request->from);
            $to = new DateTime($request->to);
            while($from <= $to){
                $u[] = $from->format('Y-m-d');
                $from->modify('1 day');
            }
            $data['usage'] = array_keys(array_count_values(DayMachine::whereIn('day', $u)->pluck('machine_id')->toarray()));
        }else{
            $data['usage'] = null;
        }
        
        // dd($data);
        return view('pctool', $data);
    }
    //
    public function detail(Request $request){
        $id= $request->id;
        $data = [
            'machine_details' => MachineDetail::find($id),
            'orders' => Order::join('machine_detail_order','orders.order_id','=','machine_detail_order.order_id')
                ->join('machine_details','machine_detail_order.machine_id','=','machine_details.machine_id')
                ->where('machine_details.machine_id',$id)
                ->get(),
            'maintenances' => Maintenance::where('machine_id',$id)->get()
        ];
        return view('pctool/detail', $data);
    }
    public function error(Request $request){
        // $data = [
        //     'records' => MachineDetail::all(),
        //     'user' => Auth::user(),
        //     'input' => $request,
        //     'inUse' => implode(',',$request->session()->get('inUse')),
        // ];
        $request->session()->reflash();
        return back()->withInput();
    }

}
