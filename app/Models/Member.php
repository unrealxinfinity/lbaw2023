<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $fillable = [
        'name',
        'email',
        'user_id',
        'picture'
    ];

    public function persistentUser(): BelongsTo
    {
        return $this->belongsTo(PersistentUser::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function worlds(): BelongsToMany
    {
        return $this->belongsToMany(World::class)->withPivot('is_admin');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'assignee');
    }

    public function worldComments(): HasMany
    {
        return $this->hasMany(WorldComment::class);
    }

    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class);
    }
}
