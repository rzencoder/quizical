@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                @component('components.who')                     
                @endcomponent  
                
                
            </div>
            <h1>QUIZICAL</h1>
                <h4>The Classroom Quiz App</h4>
                <button class="btn btn-1">Students</button><br>
                <button class="btn btn-2">Teachers</button>
        </div>
    </div>
</div>
@endsection
