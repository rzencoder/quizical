<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function addAnswers($answer, $correct)
    {
        return $this->answers()->create([
            'answer' => $answer,
            'correct' => $correct
        ]);

    }

}
