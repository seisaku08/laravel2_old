<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HeloController extends Controller
{
    public function index(){
        return view('helo', ['message' => 'please type...']);
    }
}
