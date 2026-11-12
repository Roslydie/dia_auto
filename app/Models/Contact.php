<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'service',
        'year',
        'make',
        'model',
        'need',
        'name',
        'phone',
        'email',
        'runs',
        'zip',
        'photos',
    ];

    protected function casts(): array
    {
        return [
            'photos' => 'array',
        ];
    }
}
