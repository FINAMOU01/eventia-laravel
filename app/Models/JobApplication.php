<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    /** Uploaded documents, in the order requested on the recruitment page. */
    public const DOCUMENTS = ['cv', 'cover_letter', 'photo_portrait', 'photo_full'];

    protected $fillable = [
        'locale', 'name', 'phone', 'email', 'city', 'mission_type', 'experience', 'documents', 'notified_at',
    ];

    protected function casts(): array
    {
        return ['documents' => 'array', 'notified_at' => 'datetime'];
    }
}
