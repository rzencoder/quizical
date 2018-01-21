@extends('layouts.app')

@section('welcome')
<div class="welcome-container home-bg">
    <div class="welcome-heading-container">
        <h1>QUIZICAL</h1>
        <h4>The Classroom Quiz App</h4>
        <div>
            <a href="{{ route('login') }}"><button class="btn btn-logout">Students</button></a>
            <a href="{{ route('admin.login') }}"><button class="btn btn-primary">Teachers</button></a>
        </div>
    </div>
</div>
@endsection
