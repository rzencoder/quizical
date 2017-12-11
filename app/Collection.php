<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['collection'];

    public function questions () 
    {
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function addQuestion($question)
    {
       return $this->questions()->create(compact('question'));      
    }

    public function addScore($score, $time)
    {
        return $this->scores()->create(compact('score', 'time'));
    }
}
