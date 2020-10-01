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
                    <input readonly type="text" class="form-control" placeholder="Question" name="question" value="N/A" required>
                </div>

                <div class="form-group">
                <table style="border-spacing: 5px">
                    <tbody>
                    <tr>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter1" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter2" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter3" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter4" required></td>
                    </tr>
                    <tr>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter5" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter6" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter7" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter8" required></td>
                    </tr>
                    <tr>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter9" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter10" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter11" required></td>
                        <td><input maxlength="1" type="text" class="form-control" placeholder="Letter Here" name="letter12" required></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
