<?php

namespace App\Models;

use App\Http\Controllers\FileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('permission_level');
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

    public function getProfileImage(): string
    {
        return FileController::get('profile', $this->id);
    }

    public function favoriteWorld(): BelongsToMany
    {
        return $this->belongsToMany(World::class, 'favorite_world');
    }

    public function favoriteProject(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'favorite_project');
    }

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'friend', 'member_id', 'friend_id');
    }

    public function appeal(): HasOne
    {
        return $this->hasOne(Appeal::class);
    }
}
