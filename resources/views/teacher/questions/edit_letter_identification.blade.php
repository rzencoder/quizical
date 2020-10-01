@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">Edit Question</div>
        @component('components.messages')
                
        @endcomponent
        <div class="panel-body">
            <form action="{{ route('question.edit', ['quiz' => $quiz->id, 'question' => $question->id]) }}" method="post">
            {{ csrf_field() }}
                <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" class="form-control" name="question" value="{{ $question->question }}" required></input>
                </div>
                <table>
                    @foreach($question->answers()->get() as $answer)
                        <div class="form-group">
                            <td>
                                <input type="text" class="form-control" name="letter{{$loop->iteration}}" value="{{$answer->answer}}" required>
                            </td>
                        </div>
                    @endforeach
                </table>
                <button class="btn btn-primary">Update Question</button>
            </form>
        </div>
    </div>
</div>

@endsection
