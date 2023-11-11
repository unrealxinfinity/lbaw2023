<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    public function world(): BelongsTo
    {
        return $this->belongsTo(World::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }
}
