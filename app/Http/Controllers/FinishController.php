<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Sequence;
use App\Models\DayMachine;
use App\Models\MachineDetail;
use App\Models\MachineDetailOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class FinishController extends Controller
{
    public function finish(Request $request)
    {
        $data = [
            'machines' => MachineDetail::wherein('machine_id', $request->id)->get(),
            'user' => Auth::user(),
            'input' => $request

        ];
        if($request->input('back') == 'back'){
            return redirect('/sendto')->withInput();
        }
        try{
            DB::transaction(function ()use($request) {
            //セミナー開催日から連番を取得
            $sday = new DateTime($request->seminar_day);
            $sno = Sequence::getNewOrderNo($sday->format('ymd'));
            
            //ordersテーブル
            $order = new Order;
                //order_noは日付（西暦下2桁＋月日の6桁）＋連番
                $order->order_no = sprintf('%s%04d', $sday->format('ymd'), $sno);
                $order->user_id = Auth::user()->id;
                $order->seminar_day = $request->seminar_day;
                $order->seminar_name = $request->seminar_name;
                $order->order_use_from = $request->seminar_day;
                $order->order_use_to = $request->seminar_day;
                $order->save();
            
            //order_idをmachine_detail_orderテーブルのために取得
            $last_insert_id = DB::getPdo()->lastInsertId();

            //machine_idを取得
            $id = $request->id;

            foreach($id as $i){

                //day_machineテーブルに機材占有状況を展開
                $start = new DateTime($request->shipping_arrive_day);
                $end = new DateTime($request->shipping_return_day);
                while($start <= $end){
                    $day_machine = new DayMachine;
                        $day_machine->day = date($start->format('Y-m-d'));
                        $day_machine->machine_id = $i;
                        $day_machine->save();
                    $start->modify('1 day');
                    }

                //machine_detailテーブルの使用状況
                $param = [
                    'id' => $i
                    ];

                DB::update('UPDATE machine_details SET `machine_status` = "予約中" where `machine_id` = :id', $param);

                //machine_detail_orderテーブルにオーダーと機材IDの対応を1組ずつ展開
                $mdo = new MachineDetailOrder;
                    $mdo->machine_id = $i;
                    $mdo->order_id = $last_insert_id;
                    $mdo->save();

                }


            },5);

            return view('finish', $data);
        }
        catch(\Exception $e){
            echo($e->getMessage());
            return view('confirm', $data);
        }
        finally{

        }

    }
    //
}
