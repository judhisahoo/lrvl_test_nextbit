<?php

namespace App\Http\Controllers;

use App\Events\NormalMailFireEvent;
use App\Jobs\SendEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function show_login_form(){
        return view('user.login');
    }

    function process_login(Request $request){
        $validator=Validator::make($request->all(),[
            'username'=>'required|email|exists:users,email',
            'password'=>'required|min:5'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput($request->all());
        }else{

            /********************************************** ***********************
             ************ Bellow code commented as it is for again email verification if
             ***********   user not verified while registration.
             *********************************************************/

            /*$user=User::where('email',$request->username)->whereNull('email_verified_at')->first();
            if($user){
                $dynamicLnk=md5($this->generate_string(20));
                $link=url('/varifyEmailId/'.$dynamicLnk);
                $dataArr=['user_id'=>$user->id,'link'=>$link];
                DB::table('email_varification')->insert($dataArr);
                $mailDataArr=array('name'=>$request->name,'link'=>$dynamicLnk,'email'=>$request->email);
                $this->sendMailVerifiy($mailDataArr);
                return redirect()->back()->withErrors(['error'=>"Email verification link has sent to your email address.Please check it"]);
            }else{*/
                $credetials=['email' => $request->username, 'password' => $request->password,'status'=>'A'];
                if(Auth::attempt($credetials)){
                    return redirect('/dashboard')->with('message',"Logedin successfully");;
                }else{
                    return redirect()->back()->withErrors(['error'=>"Invalid username and password or your account may be inactive."]);
                }
            //}
        }
    }

    private function generate_string($strength = 30) {
        //$input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    private function sendMailVerifiy($mailDetails){
        try {
        //Here send the link with SMTP
        Mail::send('emails.verify_email', ['name' => $mailDetails['name'], 'link' => $mailDetails['link']], function ($message)use ($mailDetails) {

            $message->to($mailDetails['email'])->subject('This is for email verification');
        });
            // return redirect($link);

            return true;

        } catch (\Exception $e) {
            echo $e; exit;
            return false;
        }
    }


    function show_signup_form(){
        return view('user.registration');
    }

    function process_signup(Request $request){
        $validator=Validator::make($request->all(),[
            'username'=>'required|email|unique:users,email',
            'password'=>'required|min:5|confirmed',
            'name'=>'required|min:5'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput($request->all());
        }else{
            $userArr=array('name'=>$request->name,'password'=>Hash::make($request->password),'email'=>$request->username);
            $userId=DB::table('users')->insertGetId($userArr);
            $dynamicLnk=md5($this->generate_string(20));
            $link=url('/varifyEmailId/'.$dynamicLnk);
            $dataArr=['user_id'=>$userId,'link'=>$link];
            DB::table('email_varification')->insert($dataArr);
            $mailDataArr=array('name'=>$request->name,'link'=>$dynamicLnk,'email'=>$request->username);
            $this->sendMailVerifiy($mailDataArr);
            return redirect()->back()->withErrors(['error'=>"Email verification link has sent to your email address.Please check it"]);
        }
    }

    function varifyEmailId($link){
        if($link!=''){
            $dataArr=DB::where('link',$link)->orderBy('id','DESc')->first();
            if($dataArr){
                DB::table('users')->where('id',$dataArr->id)->update(['email_verified_at'=>date('Y-m-d H:i:s')]);
                return redirect('/login')->with('message',"Email verified successfully");
            }
        }else{
            return redirect('/login');
        }
    }

    function viewDashboard(){
        return view('user.dashboard');
    }

    function sendMailByEvent(){
        NormalMailFireEvent::dispatch();
        return redirect('/dashboard')->with('message','Mail fire with event and listener successfully.');
    }

    function sendMailEnqueue(){
        $emailJob=(new SendEmail())->delay(Carbon::now()->addMinutes(5));
        dispatch($emailJob);
        return redirect('/dashboard')->with('message','Mail send to querya and fire by listener success fully.');
    }
}
