<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'number', 'grade_id',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
