<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Quiz;
use App\Question;
use App\Score;
use App\Category;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // Create New Question
    public function create (Quiz $quiz)
    {
        return view('teacher.questions.new', compact('quiz'));
    }

    // Store Question and Answers
    public function store(Quiz $quiz, Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'correct' => 'required',
            'wrong1' => 'required',
            'wrong2' => 'required',
            'wrong3' => 'required',
        ]);

        $question = $quiz->addQuestion(request('question'));
        $question->addAnswers(request('correct'), 1);
        $question->addAnswers(request('wrong1'), 0);
        $question->addAnswers(request('wrong2'), 0);
        $question->addAnswers(request('wrong3'), 0);
        return redirect()->route('quiz.editForm', ['quiz' => $quiz->id])->with('status', 'Question Added');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        return view('teacher.questions.edit', compact('quiz', 'question'));
    }

    // Save edited question
    public function editStore(Quiz $quiz, Question $question, Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'correct' => 'required',
            'wrong1' => 'required',
            'wrong2' => 'required',
            'wrong3' => 'required',
        ]);

        $question->question = request('question');
        $question->save();
        $answers = $question->answers()->get();
        // Loop through answers and assign edited answer in place
        foreach ($answers as $i => $answer) {
            if ($i === 0) {
                $answer->answer = request("correct");
                $answer->save();
            } else {
                $answer->answer = request("wrong" . $i);
                $answer->save();
            }

        }
        return redirect()->route('quiz.editForm', ['quiz' => $quiz->id])->with('status', 'Question Updated');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $answers = $question->answers()->get();
        foreach ($answers as $answer) {
            $answer->delete();
        }
        $question->delete();

        return redirect()->route('quiz.editForm', ['quiz' => $quiz->id])->with('status', 'Question Deleted');
    }

}
