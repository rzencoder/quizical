@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div>Student Dashboard</div>
        </div>
        <div class="dashboard-container">
            <h3>Welcome {{ Auth::user()->name }}</h3>
            <div class="dashboard-btns">
                <a href="{{ route('changeUserDetailsForm') }}"><button class="btn btn-primary">Update Account</button></a>
                <a href="{{ route('changeUserPasswordForm') }}"><button class="btn btn-secondary">Change Password</button></a>
                <a href="{{ route('logout') }}"><button class="btn btn-logout">Logout</button></a>
            </div>
            <div class="panel-body">
                @component('components.messages')
                    
                @endcomponent
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Latest Quizzes</div>
        <div id="accordion" role="tablist" class="accordion">         
            @foreach ($subjects as $subject)
                <div class="card">
                    <div class="category-header collapsed {{$subject[0]}}" role="tab" id="headingOne"
                        data-toggle="collapse" href="#{{ $subject[0] }}" aria-expanded="false" aria-controls="{{ $subject[0] }}">
                        <span>
                            <i class="category-icon fa fa-{{ $subject[1] }}" aria-hidden="true"></i>
                        </span>                  
                        <span>
                            {{ $subject[0] }}
                        </span>
                    </div>
                    <div id="{{ $subject[0] }}" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="quiz-list-item quiz-list-header">
                            <div>Quiz</div>                                               
                            <div>Score</div>
                            <div>Time</div>
                        </div>
                        @foreach($quizzes as $quiz)
                            @if (count($scores) !== 0)
                                @for($i = 0; $i < count($scores); $i++)
                                    @if($scores[$i]->quiz_id === $quiz['id'] && $quiz['category'] === $subject[0])
                                        <div class="quiz-list-item">
                                            <div>{{ $quiz['quiz'] }}</div>                                               
                                            <div>{{ round($scores[$i]->score / count($quiz->questions) * 100) }}%</div>
                                            <div>{{ $scores[$i]->time }}s</div>                                                          
                                        </div>
                                        <?php break;?>
                                    @elseif($i === count($scores) - 1 && $quiz['category'] === $subject[0])
                                        <div class="quiz-list-item">
                                            <span> {{ $quiz->quiz }} </span>
                                            <a href="{{ route('quiz.show', ['id' => $quiz->id]) }}"><button class="btn btn-primary">Start</button></a>
                                        </div>
                                    @endif
                                @endfor  
                            @elseif($quiz['category'] === $subject[0])
                                <div class="quiz-list-item">
                                    <span> {{ $quiz->quiz }} </span>
                                    <a href="{{ route('quiz.show', ['id' => $quiz->id]) }}"><button class="btn btn-primary">Start</button></a>
                                </div>
                            @endif                     
                        @endforeach                       
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
