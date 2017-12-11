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

    public function showEditQuestion(Collection $collection, Question $question)
    {
        return view('questions.edit', compact('collection', 'question'));
    }

    public function editQuestion(Collection $collection, Question $question)
    {
        $question->question = request('question');
        $question->save();
        $answers = $question->answers()->get();
        foreach($answers as $answer){
            $answer->answer = request("$answer->id");
            $answer->save();
        }
        return redirect('home');
    }

    public function destroy(Collection $collection, Question $question)
    {
        $answers = $question->answers()->get();
        foreach ($answers as $answer) {
            $answer->delete();
        }
        $question->delete();

        return redirect('home');
    }
}
