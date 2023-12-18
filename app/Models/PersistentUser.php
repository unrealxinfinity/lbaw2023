<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

enum UserType: string 
{
    case Member = 'Member';
    case Administrator = 'Administrator';
    case Deleted = 'Deleted';
    case Blocked = 'Blocked';
}

class PersistentUser extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $fillable = [
        'type_',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'user_id');
    }

    protected $table = 'users';
}
