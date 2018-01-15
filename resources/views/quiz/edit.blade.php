@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Quiz</div>
                    @if(isset($message))
                        <div>{{ $message }}</div>
                    @endif
                     @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-body">
                        
                        <form action="/edit-quiz/{{$quiz->id}}" method="post">
                        {{ csrf_field() }}
                             <input name="name" value="{{ $quiz->quiz }}"></input>
                             <button class="btn btn-primary">Update Quiz Name</button>
                        </form>

                        <a href="/create-question/{{$quiz->id}}"><button class="btn btn-primary">Add Question</button></a>

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
                        
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
