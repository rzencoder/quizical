@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h2>Scores</h2>
                @foreach($scores as $score)
                    <div>{{$score}}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
