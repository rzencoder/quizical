@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h2>{{ $collection->collection }}</h2>
                <h3>New Question</h3>          
                <form method="POST" action="/create-question/{{$collection->id}}">
                    {{ csrf_field()}}
                    @if(isset($message))
                        {{$message}}
                    @endif
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" class="form-control" placeholder="Question" name="question">
                    </div>

                    <div class="form-group">
                        <label for="correct answer">Correct Answer</label>
                        <input type="text" class="form-control" placeholder="Correct Answer" name="correct">
                    </div>

                    <div class="form-group">
                        <label for="wrong answer">Wrong Answer</label>
                        <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong1">
                    </div>
                    
                    <div class="form-group">
                        <label for="wrong answer">Wrong Answer</label>
                        <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong2">
                    </div>

                    <div class="form-group">
                        <label for="wrong answer">Wrong Answer</label>
                        <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong3">
                    </div>
                    
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
