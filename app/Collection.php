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

    public function addQuestion($question)
    {
       
       return $this->questions()->create(compact('question'));
            
    }
}
