<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Quiz;
use App\Question;
use App\Score;
use function bar\baz\foo;

class QuizController extends Controller
{
    public $subjects = [['computing', 'laptop'], ['english', 'book'], ['geography', 'globe'], ['history', 'bank'], ['maths', 'calculator'], ['music', 'music'], ['science', 'flask'], ['technology', 'wrench']];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function newQuestion(Quiz $quiz)
    {       
        return view('dashboard.new', compact('quiz'));
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

        return redirect()->route('quiz.newQuestion', ['quiz' => $quiz->id]);
    }

    public function edit(Quiz $quiz)
    {   
        $subjects = $this->subjects;
        return view('quiz.edit', compact('quiz', 'subjects'));
    }

    public function changeQuizName(Quiz $quiz, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'category' => 'required',
        ]);

        $quiz->quiz = request('name');
        $quiz->category = request('category');
        $quiz->save();
        $subjects = $this->subjects;
        return view('quiz.edit', compact('quiz', 'subjects'))->with('status', 'Quiz Updated');;
    }

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

    public function showEditQuestion(Quiz $quiz, Question $question)
    {
        return view('questions.edit', compact('quiz', 'question'));
    }

    public function editQuestion(Quiz $quiz, Question $question, Request $request)
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
        foreach ($answers as $i => $answer) {
            if($i === 0){
                $answer->answer = request("correct");
                $answer->save();
            } else {
                $answer->answer = request("wrong".$i);
                $answer->save();
            }
           
        }
        return redirect()->route('quiz.editForm', ['quiz' => $quiz->id])->with('status', 'Question Updated');
    }

    public function destroyQuestion(Quiz $quiz, Question $question)
    {
        $answers = $question->answers()->get();
        foreach ($answers as $answer) {
            $answer->delete();
        }
        $question->delete();

        return redirect()->route('quiz.editForm', ['quiz' => $quiz->id])->with('status', 'Question Deleted');
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
        return view('dashboard.scores', compact('scores', 'quiz'));
    }

    public function present(Quiz $quiz, Request $request)
    {
        $validatedData = $request->validate([
            'time' => 'required|numeric'
        ]);
        $time = request('time');
        return view('dashboard.present', ['time' => $time ]);
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
