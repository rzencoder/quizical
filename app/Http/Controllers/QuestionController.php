<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Question;
use App\Quiz;
use App\Score;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $quizzes = Quiz::latest()->get();
        $user = Auth::user();
        $scores = $user->scores()->get();
        return view('home', compact('quizzes', 'scores'));
    }

    public function show(Quiz $quiz)
    {
        $user = Auth::user();
        $scores = $user->scores()->get();
        foreach ($scores as $score) {
            if ($quiz->id === $score->quiz_id) {
                return redirect('/quizzes');
            }
        }
        return view('questions.show', compact('quiz'));
    }

    public function showQuizzes()
    {
        $quizzes = Quiz::latest()->get();
        return view('quiz.index', compact('quizzes'));
    }

    public function questions(Quiz $quiz)
    {
        $questions = $quiz->questions;
        $answers = [];
        foreach ($questions as $question) {
            array_push($answers, $question->answers);
        }
        return compact('quiz', 'questions', 'answers');
    }

    public function results(Quiz $quiz)
    {
        $score = request('score');
        $time = request('time');
        $quiz_id = $quiz->id;
        $quiz = auth()->user()->saveScore(
            new Score(compact('score', 'time', 'quiz_id'))
        );
        return ['message' => 'Result Submitted'];
    }

}
