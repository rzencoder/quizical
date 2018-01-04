<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Question;
use App\Quiz;
use App\Score;
use Illuminate\Support\Facades\Hash;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $quizzes = Quiz::latest()->get()->sortBy('category');
        $user = Auth::user();
        $scores = $user->scores()->get();
        $subjects = ['english', 'computing', 'geography', 'history', 'maths', 'music', 'science', 'technology'];
        return view('home', compact('quizzes', 'scores', 'subjects'));
    }

    public function show(Quiz $quiz)
    {
        $user = Auth::user();
        $scores = $user->scores()->get();
        foreach ($scores as $score) {
            if ($quiz->id === $score->quiz_id) {
                return redirect('home');
            }
        }
        return view('questions.show', compact('quiz'));
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

    public function showChangePasswordForm()
    {
        return view('auth.changepassword');
    }

    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully !");

    }

    public function showChangeUserDetailsForm()
    {
        return view('auth.changeuserdetails');
    }

    public function changeUserDetails(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'name' => 'required|string',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->name = $request->get('name');
        $user->save();

        return redirect()->back()->with("success", "Details changed successfully !");

    }

}
