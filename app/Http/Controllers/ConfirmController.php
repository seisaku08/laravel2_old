<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendtoRequest;
use Illuminate\Http\Request;

class ConfirmController extends Controller
{
    //
    public function post(SendtoRequest $request){
        dd($request);
        return view('confirm');
    }
}
