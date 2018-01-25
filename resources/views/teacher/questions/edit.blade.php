@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="panel panel-default edit-question-container">
        <div class="panel-heading">Edit Question #
            @foreach ($quiz->questions as $q)
                @if ($q->id === $question->id)
                    {{ $loop->iteration }}
                @endif
            @endforeach
        </div>
        <div class="panel-subheading {{ $quiz->category }}">
        @foreach ($subjects as $subject)
                @if ($subject[0] === $quiz->category)
                    <i class="category-icon fa fa-{{ $subject[1] }}" aria-hidden="true"></i>
                @endif                              
            @endforeach
            {{ $quiz->quiz }}
        </div>
        @component('components.messages')
      
        @endcomponent
        <div class="panel-body">
            <form action="{{ route('question.edit', ['quiz' => $quiz->id, 'question' => $question->id]) }}" method="post">
            {{ csrf_field() }}
                <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" class="form-control" name="question" value="{{ $question->question }}" required></input>
                </div>
                @foreach($question->answers()->get() as $answer)
                    @if ($loop->iteration === 1)
                        <div class="form-group">
                            <label class="text-success" for="correct answer">Correct Answer</label>
                            <input type="text" class="form-control" name="correct" value="{{$answer->answer}}" required>
                        </div>
                    @else
                        <div class="form-group">
                            <label class="text-danger" for="wrong answer">Wrong Answer {{$loop->iteration-1}}</label>
                            <input type="text" class="form-control" name="wrong{{$loop->iteration-1}}" value="{{$answer->answer}}" required>
                        </div>
                    @endif
                @endforeach
                <button class="btn btn-primary">Update Question</button>
            </form>
        </div>
    </div>
</div>

@endsection
