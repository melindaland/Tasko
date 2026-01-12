<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'sprint_id',
        'epic_id',
        'assigned_to',
        'assigned_users',
        'title',
        'description',
        'status',
        'due_date',
        'order',
        'attachments',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
        'attachments' => 'array',
        'assigned_users' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            if (auth()->check() && !$task->created_by) {
                $task->created_by = auth()->id();
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function epic()
    {
        return $this->belongsTo(Epic::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
