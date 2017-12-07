<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collection;

class CollectionsController extends Controller
{
    public function index()
    {
        $collections = Collection::latest()->get();
        return view('collections.index', compact('collections'));
    }

    public function show(Collection $collection)
    {
        return view('questions.show', compact('collection'));
    }

    public function questions(Collection $collection)
    {   
        $questions = $collection->questions;
        $answers = [];
        foreach($questions as $question){
            array_push($answers, $question->answers);
        }
        return compact('collection', 'questions', 'answers');
    }
}
