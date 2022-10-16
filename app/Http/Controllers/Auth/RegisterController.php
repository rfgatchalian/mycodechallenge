<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserReferred;
use Illuminate\Support\Facades\Crypt;
use App\Models\referralInvite;
use Illuminate\Contracts\Encryption\DecryptException;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'code' => ['nullable', 'string', 'exists:users,invite_code'],
        ],['code.exists' => 'Invitation Code is Invalid']);
       
        $validator->after(function ($validator) use ($data){
            //check the user if invites more that 
            $referred = UserReferred::with(['referred' => function($q) use ($data){
                $q->where('invite_code', '=', $data['code']);
            }])->get();
                if(count($referred) == 10)
                    $validator->errors()->add('code', 'Invitation code exceed.');
        });
            
        
        return $validator;
    }
    

   
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        //check if invite code is valid and not exceeded to limit
            
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            //insert user referred id code is valid
            if($data['code'] != null){
                $referred_by = User::where('invite_code',$data['code'])->first();
                $userReferred = new UserReferred;
                $userReferred->referred_by = $referred_by->id;
                $userReferred->user_id = $user->id;
                $userReferred->save();
            }
            return $user;
        
        
    }
    public function showRegistrationForm($id=null)
    {
        $email = '';
        $code = '';
       
       
        if($id != null){
            try{
                $id = Crypt::decrypt($id);
                $referrals = referralInvite::find($id);
                if($referrals)
                {
                    $code = User::find($referrals->invite_by)->value('invite_code');
                    $email = $referrals->email;
                }
            }
            catch(DecryptException $e){
                $code = $id;
            }
            
         
            
        }

        return view('auth.register')->with(compact('email','code'));
    }
}
