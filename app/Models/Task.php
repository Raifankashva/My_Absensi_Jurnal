<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status'
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isDue()
    {
        return $this->due_date->isPast();
    }

    public function isUpcoming()
    {
        return $this->due_date->diffInHours(now()) <= 24;
    }
}