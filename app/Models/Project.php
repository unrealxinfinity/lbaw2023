<?php

namespace App\Models;

use App\Http\Controllers\FileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

enum ProjectStatus: string
{
    case Active = 'Active';
    case Archived = 'Archived';
}

enum ProjectPermission: string 
{
    case Leader = 'Project Leader';
    case Member = 'Member';
}

class Project extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'status',
        'picture',
        'world_id',
    ];
    public function world(): BelongsTo
    {
        return $this->belongsTo(World::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    public function tags(): BelongsToMany
    {
       return $this->belongsToMany(Tag::class, 'project_tag');
    }

    public function getImage(): string
    {
        return FileController::get('project', $this->id);
    }
}
