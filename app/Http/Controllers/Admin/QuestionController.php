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
        if($quiz->category == 'letter_identification'){
            return view('teacher.questions.new_letter_identification', compact('quiz'));
        }
        elseif ($quiz->category == 'multiple_choice'){
            return view('teacher.questions.new_multiple_choice', compact('quiz'));
        }
    }

    // Store Question and Answers
    public function store(Quiz $quiz, Request $request)
    {
        if($quiz->category == 'letter_identification') {
            $validatedData = $request->validate([
                'question' => 'required',
                'letter1' => 'required',
                'letter2' => 'required',
                'letter3' => 'required',
                'letter4' => 'required',
                'letter5' => 'required',
                'letter6' => 'required',
                'letter7' => 'required',
                'letter8' => 'required',
                'letter9' => 'required',
                'letter10' => 'required',
                'letter11' => 'required',
                'letter12' => 'required',
            ]);

            $question = $quiz->addQuestion(request('question'));
            $question->addAnswers(request('letter1'), 0);
            $question->addAnswers(request('letter2'), 0);
            $question->addAnswers(request('letter3'), 0);
            $question->addAnswers(request('letter4'), 0);
            $question->addAnswers(request('letter5'), 0);
            $question->addAnswers(request('letter6'), 0);
            $question->addAnswers(request('letter7'), 0);
            $question->addAnswers(request('letter8'), 0);
            $question->addAnswers(request('letter9'), 0);
            $question->addAnswers(request('letter10'), 0);
            $question->addAnswers(request('letter11'), 0);
            $question->addAnswers(request('letter12'), 0);
            return redirect()->route('quiz.editForm', ['quiz' => $quiz->id])->with('status', 'Question Added');
        }

        if($quiz->category == 'multiple_choice') {
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
    }

    public function edit(Quiz $quiz, Question $question)
    {
        if($quiz->category == 'letter_identification') {
            return view('teacher.questions.edit_letter_identification', compact('quiz', 'question'));
        }
        elseif ($quiz->category == 'multiple_choice'){
            return view('teacher.questions.edit_multiple_choice', compact('quiz', 'question'));
        }
    }

    // Save edited question
    public function editStore(Quiz $quiz, Question $question, Request $request)
    {
        if($quiz->category == 'letter_identification') {
            $validatedData = $request->validate([
                'question' => 'required',
                'letter1' => 'required',
                'letter2' => 'required',
                'letter3' => 'required',
                'letter4' => 'required',
                'letter5' => 'required',
                'letter6' => 'required',
                'letter7' => 'required',
                'letter8' => 'required',
                'letter9' => 'required',
                'letter10' => 'required',
                'letter11' => 'required',
                'letter12' => 'required',
            ]);

            $question->question = request('question');
            $question->save();
            $answers = $question->answers()->get();
            // Loop through answers and assign edited answer in place
            foreach ($answers as $i => $answer) {
                $answer->answer = request("letter" . $i);
                $answer->save();
            }
            return redirect()->route('quiz.editForm', ['quiz' => $quiz->id])->with('status', 'Question Updated');
        }
        elseif($quiz->category == 'multiple_choice') {
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
