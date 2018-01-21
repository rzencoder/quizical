<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static $subjects = [['computing', 'laptop'], ['english', 'book'], ['geography', 'globe'], ['history', 'bank'], ['maths', 'calculator'], ['music', 'music'], ['science', 'flask'], ['technology', 'wrench']];

}
