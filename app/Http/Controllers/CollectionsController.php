<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collection;

class CollectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'questions', 'answers']);
    }

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

    public function results (Collection $collection) {
        return ['message' => 'Result Submitted'];
    }

    public function newquestion(Collection $collection)
    {
        $collection = Collection::latest()->get()->first();
        return view('dashboard.new', compact('collection'));
    }

    public function create()
    {
        
        $collection = auth()->user()->publish(
            new Collection(request(['collection']))
        );

        return redirect("/create-question/{$collection->id}");
    }

}
