<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'access_code',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    public function isOwner($userId)
    {
        return $this->owner_id === $userId;
    }

    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    public static function generateUniqueAccessCode()
    {
        do {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('access_code', $code)->exists());

        return $code;
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }

    public function epics()
    {
        return $this->hasMany(Epic::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }
}
