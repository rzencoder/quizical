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
                        <form action="/edit-quiz/{{$quiz->id}}" method="post">
                        {{ csrf_field() }}
                             <input name="name" value="{{ $quiz->quiz }}"></input>
                             <button class="btn btn-primary">Update Quiz Name</button>
                        </form>

                        @foreach($quiz->questions()->get() as $question)
                                <div>
                                    <div>{{$question->question}}</div>
                                    <a href="/edit-quiz/{{$quiz->id}}/question/{{$question->id}}"><button class="btn btn-primary">Edit Question</button></a>
                                    <form method="POST" action="/delete-quiz/{{$quiz->id}}/question/{{$question->id}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-primary" type="submit">Delete</button>
                                    </form>
                                </div>
                        @endforeach
                        <a href="/create-question/{{$quiz->id}}"><button class="btn btn-primary">Add Question</button></a>
                    </div>
              
                
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
