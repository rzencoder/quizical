@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Question</div>
                    @if(isset($message))
                        <div>{{ $message }}</div>
                    @endif
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif              
                </div>
                <div class="panel-body">
                    <form action="/edit-quiz/{{$quiz->id}}/question/{{$question->id}}" method="post">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" name="question" value="{{ $question->question }}"></input>
                        </div>
                        @foreach($question->answers()->get() as $answer)
                            @if ($loop->iteration === 1)
                                <div class="form-group">
                                    <label class="text-success" for="correct answer">Correct Answer</label>
                                    <input type="text" class="form-control" name="{{$answer->id}}" value="{{$answer->answer}}">
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="text-danger" for="wrong answer">Wrong Answer {{$loop->iteration}}</label>
                                    <input type="text" class="form-control" name="{{$answer->id}}" value="{{$answer->answer}}">
                                </div>
                            @endif
                        @endforeach
                        <button class="btn btn-primary">Update Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
