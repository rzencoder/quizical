@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                @component('components.who')
                        
                @endcomponent  
                <div class="panel-heading">User Dashboard</div>
                <a href="/quizzes">
                    <button class="btn btn-primary">See Latest Quizzes</button>
                </a>
                <a href="/home">
                    <button class="btn btn-primary">Create New Quiz</button>
                </a>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
