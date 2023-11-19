<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorldComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'world_id',
        'member_id'
    ];

    public $timestamps = false;

    public function world(): BelongsTo
    {
        return $this->belongsTo(World::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
