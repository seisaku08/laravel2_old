<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\MachineDetail;
use Illuminate\Http\Request;

class SendtoController extends Controller
{
    //
    public function view(Request $request){
        $data = [
            'records' => MachineDetail::all(),
            'user' => Auth::user(),
            'input' => $request

        ];
        // dd($data);
        return view('sendto', $data);
    }
}
