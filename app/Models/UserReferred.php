<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserReferred extends Model
{
    use HasFactory;

    protected $table = 'user_referreds';

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
