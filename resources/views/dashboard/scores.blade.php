@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <h2>Category: {{ $quiz->category }}</h2>
                <h2>Quiz: {{ $quiz->quiz }}</h2>
                <h4>Scores</h4>
                <a href="/admin"><button class="btn btn-primary">Back to Dashboard</button></a>
                @foreach($scores as $score)
                    <div>{{$score->name}}</div>
                    <div>{{$score->score}}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
