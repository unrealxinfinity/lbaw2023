<?php

namespace App\Models;

use App\Http\Controllers\FileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class World extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id', 
        'name',
        'description',
        'picture',
        'owner_id'
    ];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'owner_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(WorldComment::class);
    }

    public function getImage(): string
    {
        return FileController::get('world', $this->id);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

}
