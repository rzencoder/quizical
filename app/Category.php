<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static $subjects = [['letter_identification', 'laptop'], ['multiple_choice', 'book'], ['geography', 'globe'], ['history', 'bank'], ['maths', 'calculator'], ['music', 'music'], ['science', 'flask'], ['technology', 'wrench']];

}
