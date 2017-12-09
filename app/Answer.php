<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['answer', 'correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
