@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Quiz</div>
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
                        <input name="question" value="{{ $question->question }}"></input>
                        @foreach($question->answers()->get() as $answer)
                                <div>
                                    <input name="{{$answer->id}}" value="{{$answer->answer}}"></input>
                                </div>
                        @endforeach
                        <button class="btn btn-primary">Update Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
