<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Quiz;
use App\Question;
use App\Score;
use App\Category;
use function bar\baz\foo;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'quiz' => 'required|string',
            'category' => 'required|string',
        ]);
        
        $quiz = auth()->user()->publish(
            new Quiz(request(['quiz', 'category']))
        );

        return redirect()->route('question.create', ['quiz' => $quiz->id]);
    }

    public function edit(Quiz $quiz)
    {
        $subjects = Category::$subjects;
        return view('teacher.quiz.edit', compact('quiz', 'subjects'));
    }

    public function store(Quiz $quiz, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'category' => 'required',
        ]);
        $quiz->quiz = request('name');
        $quiz->category = request('category');
        $quiz->save();
        return redirect()->route('quiz.edit', ['quiz' => $quiz->id ])->with('status', 'Quiz Updated');;
    }

    public function show(Quiz $quiz, Request $request)
    {
        $validatedData = $request->validate([
            'time' => 'required|numeric'
        ]);

        $date = Carbon::now()->subMinutes(request('time'));
        $scores = $quiz->scores()->where('created_at', '>', $date)->get();
        $users = [];
        foreach ($scores as $score) {
            $score->name = $score->user()->get()[0]->name;
        }
        $scores = $scores->sortByDesc('score');
        return view('teacher.quiz.scores', compact('scores', 'quiz'));
    }

    public function present(Quiz $quiz, Request $request)
    {
        $validatedData = $request->validate([
            'time' => 'required|numeric'
        ]);
        $time = request('time');
        return view('teacher.quiz.present', ['time' => $time ]);
    }

    public function presentData(Quiz $quiz, Request $request)
    {
        $validatedData = $request->validate([
            'time' => 'required|numeric'
        ]);
        $date = Carbon::now()->subMinutes(request('time'));
        $scores = $quiz->scores()->where('created_at', '>', $date)->get();
        
        $users = [];
        foreach ($scores as $score) {
            $score->name = $score->user()->get()[0]->name;
        }
        
        $scores = $scores->toArray();
        usort($scores, function ($first, $second) {
            return $first['time'] > $second['time'];
        });
        usort($scores, function ($first, $second) {
            return $first['score'] < $second['score'];
        });
        return compact('scores', 'quiz');
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

        return redirect()->route('admin.dashboard')->with('status', 'Quiz Deleted');
    }

}
