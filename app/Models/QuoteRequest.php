<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'locale', 'name', 'organisation', 'phone', 'email', 'pole', 'service_type',
        'project_date', 'location', 'budget', 'description', 'notified_at',
    ];

    protected function casts(): array
    {
        return ['project_date' => 'date', 'notified_at' => 'datetime'];
    }
}
