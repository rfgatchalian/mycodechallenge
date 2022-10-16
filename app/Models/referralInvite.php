<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referralInvite extends Model
{
    use HasFactory;
    
    protected $table = 'referral_invites';
    protected $fillable = [
        'invite_by',
        'email',
    ];
}
