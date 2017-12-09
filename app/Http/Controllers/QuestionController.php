<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Collection;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->get();    
        return view('questions.index', compact('questions'));
    }

    public function store(Collection $collection)
    {      
        $question = $collection->addQuestion(request('question'));
        $question->addAnswers(request('correct'), 1);
        $question->addAnswers(request('wrong1'), 0);
        $question->addAnswers(request('wrong2'), 0);
        $question->addAnswers(request('wrong3'), 0);
        
        return redirect("/create-question/{$collection->id}");
    }
}
