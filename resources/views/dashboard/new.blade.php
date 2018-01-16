@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading {{ $quiz->category }}">
                    <div>{{ $quiz->quiz }}</div>
                </div>
                <div class="new-question-container">         
                    <form method="POST" action="/create-question/{{$quiz->id}}">
                        {{ csrf_field()}}
                        @if(isset($message))
                            <div class="text-success">{{$message}}</div>
                        @endif
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" placeholder="Question" name="question">
                        </div>

                        <div class="form-group">
                            <label class="text-success" for="correct answer">Correct Answer</label>
                            <input type="text" class="form-control" placeholder="Correct Answer" name="correct">
                        </div>

                        <div class="form-group">
                            <label class="text-danger" for="wrong answer">Wrong Answer 1</label>
                            <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong1">
                        </div>
                        
                        <div class="form-group">
                            <label class="text-danger" for="wrong answer">Wrong Answer 2</label>
                            <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong2">
                        </div>

                        <div class="form-group">
                            <label class="text-danger" for="wrong answer">Wrong Answer 3</label>
                            <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong3">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
