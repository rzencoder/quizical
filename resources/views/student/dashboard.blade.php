@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div>Student Dashboard</div>
        </div>
        <div class="dashboard-container">
            <h3>Welcome {{ Auth::user()->name }}</h3>
            <div class="panel-body">
                @component('components.messages')
                    
                @endcomponent
            </div>
            <div class="dashboard-btns">
                <a class="btn btn-primary" role="button" href="{{ route('changeUserDetailsForm') }}">Update Account</a>
                <a class="btn btn-secondary" role="button" href="{{ route('changeUserPasswordForm') }}">Change Password</a>
                <a class="btn btn-logout" role="button" href="{{ route('user.logout') }}">Logout</a>
            </div>
            
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Latest Quizzes</div>

        {{--  Accordion Menu  --}}
        <div id="accordion" role="tablist" class="accordion">     
            {{-- Loop through each subject to created colored subject headers    --}}
            @foreach ($subjects as $subject)
                <div class="card">
                    <a role="tab" data-toggle="collapse" href="#{{ $subject[0] }}" aria-expanded="false" aria-controls="{{ $subject[0] }}">
                    <div class="category-header collapsed {{$subject[0]}}">
                        <span>
                            <i class="category-icon fa fa-{{ $subject[1] }}" aria-hidden="true"></i>
                        </span>                  
                        <span>
                            {{ $subject[0] }}
                        </span>
                    </div>
                    </a>
                    {{--  Collapsable area of accordion menu  --}}
                    <div id="{{ $subject[0] }}" class="collapse" role="tabpanel"  data-parent="#accordion">
                        <div class="quiz-list-item quiz-list-header">
                            <div>Quiz</div>                                               
                            <div>Score</div>
                            <div>Time</div>
                        </div>
                        {{--  Loop through each quiz  --}}
                        @foreach($quizzes as $quiz)
                            {{--  Check if user has played any quizzes before  --}}
                            @if (count($scores) !== 0)
                                {{--  Loop through user scores  --}}
                                @for($i = 0; $i < count($scores); $i++)
                                    {{--  If user has played quiz display score  --}}
                                    @if($scores[$i]->quiz_id === $quiz['id'] && $quiz['category'] === $subject[0])
                                        <div class="quiz-list-item">
                                            <div>{{ $quiz['quiz'] }}</div>                                               
                                            <div>{{ round($scores[$i]->score / count($quiz->questions) * 100) }}%</div>
                                            <div>{{ $scores[$i]->time }}s</div>                                                          
                                        </div>
                                        <?php break;?>
                                    {{--  If user not played display stert button  --}}
                                    @elseif($i === count($scores) - 1 && $quiz['category'] === $subject[0])
                                        <div class="quiz-list-item">
                                            <span> {{ $quiz->quiz }} </span>
                                            <a class="btn btn-primary" role="button" href="{{ route('quiz.show', ['id' => $quiz->id]) }}">Start</a>
                                        </div>
                                    @endif
                                @endfor  
                            @elseif($quiz['category'] === $subject[0])
                                <div class="quiz-list-item">
                                    <span> {{ $quiz->quiz }} </span>
                                    <a class="btn btn-primary" role="button" href="{{ route('quiz.show', ['id' => $quiz->id]) }}">Start</a>
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
