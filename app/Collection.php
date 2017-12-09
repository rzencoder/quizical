<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['collection', 'author'];

    public function questions () 
    {
        return $this->hasMany(Question::class);
    }

    public function addQuestion($question)
    {
       
       return $this->questions()->create(compact('question'));
            
    }
}
