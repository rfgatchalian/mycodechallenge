<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserReferred;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\referralInvite;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvite;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $UserReferred = UserReferred::with('user')->get();
        return view('referral')->with(compact('UserReferred'));

    }
    public function sendInvite(Request $request){

       
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            
        ]);

       
        
        $validator->after(function ($validator) use ($request){
            //check if email is already registered
            $user = User::where('email',$request->input('email'))->first();
            if($user)
                $validator->errors()->add('email', 'Email already registered');

            //check if email is already invited
            $referralInvite = referralInvite::where('email',$request->input('email'))->where('invite_by',Auth::id())->first();
            if($referralInvite)
                $validator->errors()->add('email', 'Email already invited');
            
            //check if limit exceed
            $invites = UserReferred::where('referred_by',Auth::id())->count();
            if($invites >= 10){
                $validator->errors()->add('email', 'Your account reach the limit');
            }
        });
        if($validator->fails()){
            
            return back()->withErrors($validator)->withInput($request->input());
        }
        
        
        //save
        $referralInvite = referralInvite::create([
            'invite_by' => Auth::id(),
            'email' => $request->input('email'),
        ]);
        $user = User::find(Auth::id());
        $mailData = [
            "name" => $user->name,
            "invite_code" => Crypt::encrypt($referralInvite->id),
        ];

        //send invite email
        Mail::to($request->input('email'))->queue(new SendInvite($mailData));

        return back()->with('success', 'Invitation sent');  

    }
}
