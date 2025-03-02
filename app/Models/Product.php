<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category'
    ];

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }
}
