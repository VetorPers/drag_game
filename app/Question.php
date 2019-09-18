<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'type', 'desc', 'img', 'level', 'pest_id'];

    public function getImgAttribute($value)
    {
        if ( !empty($value)) return asset('storage/' . $value);
    }

    public function pest()
    {
        return $this->belongsTo(Pest::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function right_answer_ids()
    {
        return $this->answers()->where('is_right', 1)->get()->pluck('id')->all();
    }

    public function is_right($answerId)
    {
        $res = false;
        $rightAnswerIds = $this->right_answer_ids();

        if ($this->attributes['type'] == 2) {
            if (empty(array_diff($answerId, $rightAnswerIds))) $res = true;
        } else {
            if (count($answerId) == 1 && in_array($answerId[0], $rightAnswerIds)) $res = true;
        }

        return $res;
    }
}
