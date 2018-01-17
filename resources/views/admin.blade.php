@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                 <div class="panel-heading">
                    <div>Dashboard</div>
                </div>
                <div class="dashboard-container">                
                    <h3>Welcome {{ Auth::user()->name }}</h3>
                    <a href="/admin/update"><button class="btn btn-primary">Update Account</button></a>
                    <a href="/admin/update/password"><button class="btn btn-secondary">Change Password</button></a>
                    <a href=""><button class="btn btn-logout">Logout</button></a>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div>Create New Quiz</div>
                </div>
                <div class="dashboard-container">
                    <form action="/create-quiz" method="POST">
                        {{ csrf_field() }}
                        <div class="new-quiz-container">
                            <div>
                                <input type="text" name="quiz" id="" placeholder="New Quiz Name">
                                <select name="category" id="">
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject[0] }}">{{ $subject[0] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form> 
                </div>
            </div>

            <div class="panel panel-default">
                 <div class="panel-heading">
                    <div>Your Quizzes</div>
                </div>
                <div class="dashboard-container">
                    @if(isset($quizzes))
                        @foreach($quizzes as $quiz)
                            <div class="admin-quiz-list">
                                <h2>{{ $quiz->quiz }}</h2>
                                <div class="admin-quiz-list-btns">
                                    <a href="show-results/{{$quiz->id}}"><button class="btn btn-primary">See Results</button></a>
                                    <a href="present-results/{{$quiz->id}}"><button class="btn btn-primary">Present Latest Results</button></a>
                                    <a href="edit-quiz/{{$quiz->id}}"><button class="btn btn-primary">Edit Quiz</button></a>
                                    <form method="POST" action="/delete-quiz/{{$quiz->id}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-logout" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
