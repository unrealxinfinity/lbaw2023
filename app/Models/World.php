<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class World extends Model
{
    use HasFactory;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'owner_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }
}
