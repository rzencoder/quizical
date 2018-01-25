@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="panel panel-default edit-quiz-welcome">
        <div class="panel-heading">Edit Quiz</div>
        <div class="panel-subheading {{ $quiz->category }}">
            @foreach ($subjects as $subject)
                @if ($subject[0] === $quiz->category)
                    <i class="category-icon fa fa-{{ $subject[1] }}" aria-hidden="true"></i>
                @endif                              
            @endforeach
            {{ $quiz->quiz }}
        </div>
        <div class="panel-body">
            @component('components.messages')
                        
            @endcomponent
         </div>
        <div class="panel-body edit-quiz-container">
            <div class="update-quiz-form">
                <h3>Update Quiz</h3>
                <form action="{{ route('quiz.edit', ['id' => $quiz->id]) }}" method="post">
                {{ csrf_field() }}
                    <input name="name" value="{{ $quiz->quiz }}" required>
                    <select name="category" required>
                        @foreach ($subjects as $subject)
                            @if ($subject[0] === $quiz->category)
                                <option selected value="{{ $subject[0] }}">{{ $subject[0] }}</option>
                            @else
                                <option value="{{ $subject[0] }}">{{ $subject[0] }}</option>
                            @endif                               
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Update Quiz</button>
                </form>
            </div>

            <div>
                <h3>New Question</h3>
                <a class="btn btn-primary" role="button" href="{{ route('question.create', ['id' => $quiz->id]) }}">Add Question</a>
            </div>

            <div>
                <h3>Questions</h3>
                @foreach($quiz->questions()->get() as $question)
                    <div class="edit-questions-list">
                        <div>{{$question->question}}</div>
                        <div>
                            <a class="btn btn-primary" role="button" href="{{ route('question.editForm', ['quiz' => $quiz->id, 'question' => $question->id]) }}">Edit Question</a>
                            <form method="POST" action="{{ route('question.delete', ['quiz' => $quiz->id, 'question' => $question->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-logout" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
