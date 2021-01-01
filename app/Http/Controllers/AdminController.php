<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        if(session('role') == 1) {
            $users = DB::table('users')
                ->leftJoin('subscriptions', 'users.id', '=', 'subscriptions.id_user')
                ->leftJoin('plans', 'subscriptions.id_plan', '=', 'plans.id')
                ->where('users.role', '=', '2')->get();
            // $subsriptions = DB::table()
            return view('admin.dashboard', ['users' => $users]);
        } else {
            return redirect('/auth/login');
        }
    }
  
    public function settings() {
        if(session('role') == 1) {
            $plans = DB::table('plans')->get();
            return view('admin.settings', ['plans' => $plans, ]);
        } else {
            return redirect('/auth/login');
        }
    }

    public function newPlan(Request $post) {
        if($post->id == "") {
            $plan = new Plan;
        } else {
            $plan = Plan::find($post->id);
        }

        $plan->title = $post->title;
        $plan->description = $post->description;
        $plan->price = $post->price;
        if($plan->save()) {
            $post->session()->flash('success', "Success on saving data");

        } else {
            $post->session()->flash('error', "Error on saving data");
        }

        return redirect()->action([AdminController::class, 'settings']);

    }

    public function setTrialDay(Request $post) {
        if($post->id == ''){
            //insert
            $trial = new Setting;
        } else {
            //update
            $trial = Setting::find($post->id);
        }
           $trial->trial_day = $post->trial_day;

        if($trial->save()) {
            $post->session()->flash('success', "Success on saving data");

        } else {
            $post->session()->flash('error', "Error on saving data");
        }

        return redirect()->action([AdminController::class, 'settings']);

    }

    public function getTrialDay() {
        $plans = DB::select("SELECT * FROM settings ORDER BY id DESC LIMIT 1");
        return $plans;
    }
}