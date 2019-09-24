<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pest extends Model
{
    protected $fillable = ['name', 'img', 'order', 'time'];

    public function getImgAttribute($value)
    {
        if ( !empty($value)) return asset('storage/' . $value);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
