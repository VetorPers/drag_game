<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['user_id', 'score', 'pest_id', 'answer_ids'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pest()
    {
        return $this->belongsTo(Pest::class);
    }
}
