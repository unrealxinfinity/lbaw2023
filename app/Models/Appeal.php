<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appeal extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'text',
        'member_id'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
