<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;
use App\Mail\ArgonEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use DateTime;


class UsersController extends Controller
{
    public function getLogin(Request $post){
        $is_correct = User::where([['username', '=', $post->username],['password', '=', sha1($post->pass)]])->first();
        if($is_correct && $is_correct->is_active > 0 && $is_correct->role == 2) {
            $subs = User::find($is_correct->id)->getSubscription;
            if($subs) {
                $is_subscribed = $subs->status;
                $is_paid = $subs->is_paid;
            } else {
                $is_subscribed = 0;
                $is_paid = 0;
            }
            session(['user' => $is_correct->email, 'role' => '2', 'subscription'=> $is_subscribed, 'subs_paid'=>$is_paid]);
            return redirect()->action([HomeController::class, 'index']);

        } else if($is_correct && $is_correct->is_active > 0 && $is_correct->role ==1){
            session(['user' => $is_correct->email, 'role' => 1,'subscription'=>'0']);
            return redirect()->action([AdminController::class, 'index']);

        } else if($is_correct && $is_correct->is_active == 0){
            return view('pages.auth.confirm');
        } 
        else{
            return view('pages.auth.login', array('is_login_correct'=> false));
        }
    }

    public function showRegisterForm(Request $get) {
        $ref = ($get->ref)?$get->ref:'';
        $tier = ($get->tier)?$get->tier:'';
        if(session()->has('user')) {
            if(session('role') > 1) {
                return redirect('/user-dashboard?ref='.$ref.'&tier='.$tier);
            } else {
                return redirect('/admin');
            }
         } else {
            return view('pages.auth.register', array('is_email_taken'=> false, 'ref'=>$ref, 'tier'=>$tier));
         }
    }

    public function showLoginForm() {
        if(session()->has('user')) {
           return redirect('/');
        } else {
            return view('pages.auth.login', array('is_login_correct'=> true));
        }
    }

    public function postRegister(Request $post){
        //check if email 
        $is_email_taken = User::where('email', '=', $post->email)->first();
        $ref = '';
        $tier = '';
        if($is_email_taken) {
            return view('pages.auth.register', array('is_email_taken' => true, 'ref'=>$ref, 'tier'=>$tier));
        } else {
            $user = new User;
            $user->username = $post->username;
            $user->email = $post->email;
            $user->password = sha1($post->pass);
            $user->role = 2;
            $user->is_login = 0;
            $user->is_active = 0;
            if($user->save()) {
                $data = User::where('email', '=', $post->email)->first();
                $data->is_active = 1;
                $plan = DB::select("SELECT id FROM plans ORDER BY price ASC LIMIT 1");
                $trial = DB::select("SELECT trial_day FROM settings ORDER BY id DESC LIMIT 1");

                $date = new DateTime();
                $date->modify($trial[0]->trial_day.' days');
                $trialEnd = $date->format('Y-m-d H:i:s');

                $subs = new Subscription;
                $subs->id_user = $data->id;
                $subs->id_plan = $plan[0]->id;
                $subs->is_trial = 1;
                $subs->trial_end = $trialEnd;
                $subs->is_paid = 0;
                $subs->status = 1;
                $subs->save();

                $email = ['name' => $user->username, 'address' => $user->email];

                $this->sendActivationEmail($email);

            } else {
                echo "Registraion failed. <a href='/'> back to home </a>";
            }
        }

        return redirect('/confirm');
        
    }

    public function getUsers() {
        return User::all();
    }

    
    public function sendActivationEmail($target) {
        $kirim = Mail::to($target['address'],$target['name'])->send(new ArgonEmail($target));
    }

    public function activateUser($email){
        $data = User::where('email', $email)->first();
        $data->is_active = 1;
        if($data->save()) {
            return view('pages.auth.activationsuccess', array());
        }else {
            return "failed to activate user!";
        }
    }

    public function directPayment(Request $post) {
        $is_email_taken = User::where('email', '=', $post->email)->first();
        $plan = Plan::where('id', '=', $post->plan)->first();
        if($is_email_taken) {
            return view('pages.auth.register', array('is_email_taken' => true, 'ref'=>$post->ref, 'tier'=>$post->plan));
        } else {
            return view('pages.auth.payment-front', array('is_payment_fail'=>false, 'data'=>$post, 'plan'=>$plan));
        }
    }

    public function userDashboard() {
        $users = DB::table('users')
                ->leftJoin('subscriptions', 'users.id', '=', 'subscriptions.id_user')
                ->leftJoin('plans', 'subscriptions.id_plan', '=', 'plans.id')
                ->where('users.email', '=', session('user'))->get();
        return view('admin.user-dashboard', array('data'=>$users));
    }

    public function settings() {
        return view('/admin.user-setting', array());
    }

    public function getPayment(Request $post) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = \Stripe\Charge::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                'currency' => 'usd',
                'unit_amount' => 2000,
                'product_data' => [
                    'name' => 'Stubborn Attachments',
                    'images' => ["https://static.wikia.nocookie.net/dota2_gamepedia/images/8/87/SeasonalRank4-2.png"],
                ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => '/confirm',
            'cancel_url' => '/',
        ]);
        if($charge){
            $user = new User;
            $user->username = $post->username;
            $user->email = $post->email;
            $user->password = sha1($post->pass);
            $user->role = 2;
            $user->is_login = 0;
            $user->is_active = 0;
            if($user->save()) {
                //add subscription
                $reg_user = User::where('email', $post-email)->get('id');
                $subs = new Subscription;
                $subs->id_user = $reg_user->id;
                $subs->id_plan = $post->plan;
                $subs->is_trial = 0;
                $subs->trial_end = null;
                $subs->is_paid = 1;
                $subs->status = 1;
                $subs->save();
                $this->sendActivationEmail($post->email);

            } else {
                echo "Registraion failed. <a href='/'> back to home </a>";
            }
        } else {

        }
    }
}