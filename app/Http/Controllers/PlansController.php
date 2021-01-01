<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PlansController extends Controller
{
    //
    public function getPlanData($id) {
        return Plan::find($id);
    }

    public function deletePlanData($id) {
        // $data = Plan::find($id);
        $data  = Plan::where('id',$id)->first();

        if ($data != null) {
            $data->delete();
            session()->flash('success', 'Plan deleted.');
            return true;

        } else {
            session()->flash('error', 'Failed to delete plan.');
            return false;

        }
    
    }
}