<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collection;
use App\Score;

class ScoreController extends Controller
{
    public function show (Collection $collection) 
    {
        $scores = $collection->scores()->get();
        return view('dashboard.scores', compact('scores'));
    }

    public function store (Collection $collection) {
        $score = request('score');
        $time = request('time');
        $collection_id = $collection->id;
        $collection = auth()->user()->saveScore(
            new Score(compact('score', 'time', 'collection_id'))
        );
        return ['message' => 'Result Submitted'];
    }

}
