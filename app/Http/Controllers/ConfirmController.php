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

        $data = [
            'machines' => MachineDetail::wherein('machine_id', $request->id)->get(),
            'user' => Auth::user(),
            'input' => $request

        ];

        return view('confirm', $data);
    }
}
