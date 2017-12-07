<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public function questions () 
    {
        return $this->hasMany(Question::class);
    }
}
