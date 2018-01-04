@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h2>Dashboard</h2>
                <h3>Welcome {{ Auth::user()->name }}</h3>
                <a href="/home/update"><button>Update Account</button></a>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <div class="panel-heading">Latest Quizzes</div>

                <div id="accordion" role="tablist">
                    
                    @foreach ($subjects as $subject)
                    <div class="card">
                        <div class="card-header collapsed {{$subject}}" role="tab" id="headingOne"
                             data-toggle="collapse" href="#{{ $subject }}" aria-expanded="false" aria-controls="{{ $subject }}">
                            <h5 class="mb-0">
                                {{ $subject }}
                            </h5>
                        </div>

                        <div id="{{ $subject }}" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                               @foreach($quizzes as $quiz)
                                    @for($i = 0; $i < count($scores); $i++)
                                        @if($scores[$i]->quiz_id === $quiz['id'] && $quiz['category'] === $subject)
                                            <div class="panel-body">
                                                <div> {{ $quiz['quiz'] }} 
                                                    <span>{{ $quiz['category'] }}</span>
                                                    <span>Score: {{ $scores[$i]->score }}</span>
                                                    <span>Time: {{ $scores[$i]->time }}</span>
                                                </div>                     
                                            </div>
                                            <?php break;?>
                                        @elseif($i === count($scores) - 1 && $quiz['category'] === $subject)
                                            <div class="panel-body">
                                                <a href="quiz/{{$quiz->id}}"> {{ $quiz->quiz }} </a>
                                                <div>{{ $quiz->category }}</div>
                                            </div>
                                        @endif
                                    @endfor               
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>

                

            </div>

            

        </div>
    </div>
</div>
@endsection
