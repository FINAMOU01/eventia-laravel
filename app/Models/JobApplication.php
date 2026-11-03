<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'locale', 'name', 'phone', 'email', 'city', 'mission_type', 'experience',
        'cv_path', 'cv_original_name', 'cv_mime', 'cv_size', 'notified_at',
    ];

    protected function casts(): array
    {
        return ['notified_at' => 'datetime'];
    }
}
