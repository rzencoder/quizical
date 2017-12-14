<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Quiz;
use App\Question;
use App\Score;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function newQuestion(Quiz $quiz)
    {       
        $quiz = Quiz::latest()->get()->first();
        return view('dashboard.new', compact('quiz'));
    }

    public function create()
    {     
        $quiz = auth()->user()->publish(
            new Quiz(request(['quiz']))
        );

        return redirect("/create-question/{$quiz->id}");
    }

    public function edit(Quiz $quiz)
    {
        return view('quiz.edit', compact('quiz'));
    }

    public function changeQuizName(quiz $quiz)
    {
        $quiz->quiz = request('name');
        $quiz->save();
        $message = 'Quiz Name Updated';
        return view('quiz.edit', compact('message', 'quiz'));
    }

    public function store(Quiz $quiz)
    {
        $question = $quiz->addQuestion(request('question'));
        $question->addAnswers(request('correct'), 1);
        $question->addAnswers(request('wrong1'), 0);
        $question->addAnswers(request('wrong2'), 0);
        $question->addAnswers(request('wrong3'), 0);

        return redirect("/create-question/{$quiz->id}");
    }

    public function showEditQuestion(Quiz $quiz, Question $question)
    {
        return view('questions.edit', compact('quiz', 'question'));
    }

    public function editQuestion(Quiz $quiz, Question $question)
    {
        $question->question = request('question');
        $question->save();
        $answers = $question->answers()->get();
        foreach ($answers as $answer) {
            $answer->answer = request("$answer->id");
            $answer->save();
        }
        return redirect('home');
    }

    public function destroyQuestion(Quiz $quiz, Question $question)
    {
        $answers = $question->answers()->get();
        foreach ($answers as $answer) {
            $answer->delete();
        }
        $question->delete();

        return redirect('home');
    }

    public function show(Quiz $quiz)
    {
        $scores = $quiz->scores()->get();
        return view('dashboard.scores', compact('scores'));
    }

    public function destroy(Quiz $quiz)
    {
        $questions = $quiz->questions()->get();
        foreach ($questions as $question) {
            $answers = $question->answers()->get();
            foreach ($answers as $answer) {
                $answer->delete();
            }
            $question->delete();
        }
        $quiz->delete();

        return redirect('home');
    }

}
