<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invitation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'token',
        'member_id',
        'world_id',
        'is_admin'
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }

}
