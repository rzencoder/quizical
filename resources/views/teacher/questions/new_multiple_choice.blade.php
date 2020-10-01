@extends('layouts.app')

@section('content')

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading {{ $quiz->category }}">
                <div>{{ $quiz->quiz }}</div>
            </div>
            <div class="new-question-container">
                <form method="POST" action="{{ route('question.store', ['quiz' => $quiz->id]) }}">
                    {{ csrf_field()}}
                    @component('components.messages')

                    @endcomponent
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" class="form-control" placeholder="Question" name="question" required>
                    </div>

                    <div class="form-group">
                        <label class="text-success" for="correct answer">Correct Answer</label>
                        <input type="text" class="form-control" placeholder="Correct Answer" name="correct" required>
                    </div>

                    <div class="form-group">
                        <label class="text-danger" for="wrong answer">Wrong Answer 1</label>
                        <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong1" required>
                    </div>

                    <div class="form-group">
                        <label class="text-danger" for="wrong answer">Wrong Answer 2</label>
                        <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong2" required>
                    </div>

                    <div class="form-group">
                        <label class="text-danger" for="wrong answer">Wrong Answer 3</label>
                        <input type="text" class="form-control" placeholder="Wrong Answer" name="wrong3" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection
