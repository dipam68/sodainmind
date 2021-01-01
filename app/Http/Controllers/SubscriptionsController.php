<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Mail\ArgonEmail;
use App\Mail\UpgradeEmail;
use App\Mail\CancelEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use DateTime;

class SubscriptionsController extends Controller
{
    //
    public function index() {
        return view('/pages/subscription');
    }

    public function plan($id) {
        return view('pages.plan');

    }

    public function sendActivationEmail($target) {
       
        $kirim = Mail::to($target['address'])->send(new ArgonEmail($target));
    
    }

    public function sendUpgradeEmail($target) {
       
        $kirim = Mail::to($target)->send(new UpgradeEmail($target));
    
    }

    public function sendCancelEmail($target) {
       
        $kirim = Mail::to($target)->send(new CancelEmail($target));
    
    }

    public function getPayment(Request $post) {
            $user = new User;
            $user->username = $post->username;
            $user->email = $post->email;
            $user->password = sha1($post->pass);
            $user->role = 2;
            $user->is_login = 0;
            $user->is_active = 0;
            if($user->save()) {
                //add subscription
                $reg_user = User::where('email', '=', $post->email)->first();
                $subs = new Subscription;
                $subs->id_user = $reg_user->id;
                $subs->id_plan = $post->plan;
                $subs->is_trial = 0;
                $subs->trial_end = null;
                $subs->is_paid = 1;
                $subs->status = 1;
                if($subs->save())
                {
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    
                    $customer = \Stripe\Customer::create([
                        'name' => $user->email,
                        'address' => [
                          'line1' => '510 Townsend St',
                          'postal_code' => '98140',
                          'city' => 'San Francisco',
                          'state' => 'CA',
                          'country' => 'US',
                        ],
                        'source' => $post->stripeToken
                    ]);

                    $charge = \Stripe\Charge::create([
                        'customer'     => $customer->id, 
                        'amount' => $post->amount."00",
                        'currency' => 'INR',
                        'description' => $post->description,
                        'source' => $customer->default_source
                    ]);

                    if($charge){
                        $post = ['name' => $user->username, 'address' => $post->email];

                        $this->sendActivationEmail($post);
                        return redirect('/confirm');
                    }
                } else {
                    echo "Registraion failed. <a href='/'> back to home </a>";
                } 
        }
        else {
            return view('pages.auth.payment-fail', array());
        }
    }

    public function upgradePlan(Request $post){
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
     
        $user_info = User::where('id',$post->id_user)->first();
        $customer = \Stripe\Customer::create([
            'name' => $user_info->email,
            'address' => [
              'line1' => '510 Townsend St',
              'postal_code' => '98140',
              'city' => 'San Francisco',
              'state' => 'CA',
              'country' => 'US',
            ],
            'source' => $post->stripeToken
        ]);

        $charge = \Stripe\Charge::create([
            'customer'     => $customer->id, 
            'amount' => $post->amount."00",
            'currency' => 'INR',
            'description' => $post->description,
            'source' => $customer->default_source
        ]);
        
        if($charge){
            $this->sendUpgradeEmail($post->email);
            $upgrade = Subscription::where('id_user', "=", $post->id_user)->update(array(
                'is_paid' => 1,
                'trial_end' => null,
                'is_trial' => 0
            ));
            return redirect('/user-dashboard');
        }        
    }

    public function cancelPlan(Request $post) {
        $trial = DB::select("SELECT trial_day FROM settings ORDER BY id DESC LIMIT 1");
        $today = Date("d");
        $date = new DateTime();
        $date->modify($trial[0]->trial_day.' days');
        $trialEnd = $date->format('Y-m-d H:i:s');
        $cancel = Subscription::where('id_user', "=", $post->id_user)->update(array(
            'is_paid' => 0,
            'trial_end' => Date($trialEnd),
            'is_trial' => 1
        ));
        $this->sendCancelEmail($post->email);
    }
}