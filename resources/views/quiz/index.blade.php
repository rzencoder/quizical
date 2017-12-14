@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Latest Quizzes</div>
                @foreach($quizzes as $quiz)
                    @for($i = 0; $i < count($scores); $i++)
                        @if($scores[$i]->quiz_id === $quiz ->id)
                            <div class="panel-body">
                                <div> {{ $quiz->quiz }} 
                                     <span>Score: {{ $scores[$i]->score }}</span>
                                </div>                     
                            </div>
                            <?php break;?>
                        @elseif($i === count($scores) - 1)
                            <div class="panel-body">
                                <a href="quizzes/quiz/{{$quiz->id}}"> {{ $quiz->quiz }} </a>
                            </div>
                        @endif
                    @endfor               
                @endforeach

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
