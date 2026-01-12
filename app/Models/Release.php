<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'version',
        'release_date',
        'description',
        'status',
        'created_by',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($release) {
            if (auth()->check() && !$release->created_by) {
                $release->created_by = auth()->id();
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
