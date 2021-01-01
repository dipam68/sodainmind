<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class HomeController extends Controller
{
    public function index($session=null) {
        $data = Plan::get();
        return view('pages/landing', array('session'=>$session, 'data' => $data));
    }
}
