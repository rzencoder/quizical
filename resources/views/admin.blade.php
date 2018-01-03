@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Dashboard</div>
                <div class="panel-body">
                    @component('components.who')                   
                    @endcomponent                
                </div>

                <div>
                    <h2>Admin Quizzes</h2>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                   
                    @if(isset($quizzes))
                        @foreach($quizzes as $quiz)
                        <div>
                            <div>{{ $quiz->quiz }}</div>
                            <a href="show-results/{{$quiz->id}}"><button class="btn btn-primary">See Results</button></a>
                            <a href="present-results/{{$quiz->id}}"><button class="btn btn-primary">Present Latest Results</button></a>
                            <a href="edit-quiz/{{$quiz->id}}"><button class="btn btn-primary">Edit Quiz</button></a>
                            <form method="POST" action="/delete-quiz/{{$quiz->id}}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-primary" type="submit">Delete</button>
                            </form>
                        </div>
                        @endforeach
                    @endif
                    <h3>Create New Quiz</h3>
                    <form action="/create-quiz" method="POST">
                        {{ csrf_field() }}
                        <div class="form-control">
                            <input type="text" name="quiz" id="" placeholder="New Quiz Name">
                            <input type="text" name="category" id="" placeholder="Category">
                            <button type="submit">Create</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
