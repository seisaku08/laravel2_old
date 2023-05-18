<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\MachineDetail;
use Illuminate\Http\Request;

class SendtoController extends Controller
{
    //
    public function view(Request $request){
        $mid = $request->session()->get('cartData.session_machine_id');
        $data = [
            'records' => MachineDetail::whereIn('machine_id', $mid)->get(),
            'user' => Auth::user(),
            'input' => $request

        ];
        // dd($data);
        return view('sendto', $data);
    }
}
