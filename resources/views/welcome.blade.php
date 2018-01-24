@extends('layouts.app')

@section('welcome')
<div class="welcome-container home-bg">
    <div class="welcome-heading-container">
        <h1>QUIZICAL</h1>
        <h4>The Classroom Quiz App</h4>
        <div>
            <a class="btn btn-logout" role="button" href="{{ route('login') }}">Students</a>
            <a class="btn btn-primary" role="button" href="{{ route('admin.login') }}">Teachers</a>
        </div>
    </div>
</div>
@endsection
