<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name',
        'path',
        'type',
        'model_type',
        'model_id',
        'model_category'
    ];



    public function model()
    {
        return $this->morphTo();
    }
}
