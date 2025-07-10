<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['title', 'description', 'slug', 'schema'];

    protected $casts = [
        'schema' => 'array',
    ];

    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }
}
