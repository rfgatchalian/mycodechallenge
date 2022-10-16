<?php

namespace App\Observers;


use App\Models\User;
use Illuminate\Support\Str;
class UserObserver
{
    public function creating(User $user){
        
        $existing = true;
        $randomString = '';
        while($existing){
            $randomString = Str::random(15);
            $users = User::where('invite_code',$randomString)->first();
            if(!$users)
                break;
        }
        $user->invite_code = $randomString;
        
      
    }
    /**
     * Handle the Users "created" event.
     *
     * @param  \App\Models\Users  $users
     * @return void
     */
    public function created(User $users)
    {
        //
    }

    /**
     * Handle the Users "updated" event.
     *
     * @param  \App\Models\Users  $users
     * @return void
     */
    public function updated(User $users)
    {
        //
    }

    /**
     * Handle the Users "deleted" event.
     *
     * @param  \App\Models\Users  $users
     * @return void
     */
    public function deleted(User $users)
    {
        //
    }

    /**
     * Handle the Users "restored" event.
     *
     * @param  \App\Models\Users  $users
     * @return void
     */
    public function restored(Users $users)
    {
        //
    }

    /**
     * Handle the Users "force deleted" event.
     *
     * @param  \App\Models\Users  $users
     * @return void
     */
    public function forceDeleted(Users $users)
    {
        //
    }
}
