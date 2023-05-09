<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Machine_detail;
use Illuminate\Http\Request;

class SendtoController extends Controller
{
    //
    public function view(Request $request){
        $data = [
            'records' => Machine_detail::all(),
            'user' => Auth::user(),
            'input' => $request

        ];
        // dd($data);
        return view('sendto', $data);
    }
}
