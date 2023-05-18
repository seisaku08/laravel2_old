<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendtoRequest;
use App\Models\MachineDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmController extends Controller
{
    //
    public function post(SendtoRequest $request){

        $mid = $request->session()->get('cartData.session_machine_id');
        $data = [
            'machines' => MachineDetail::whereIn('machine_id', $mid)->get(),
            'user' => Auth::user(),
            'input' => $request

        ];

        if($request->input('back') == 'back'){
            return redirect()->action('CartController@view');
        }

        return view('confirm', $data);
    }
}
