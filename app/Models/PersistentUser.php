<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersistentUser extends Model
{
    use HasFactory;

    public $timestamps  = false;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }

    protected $table = 'users';
}
