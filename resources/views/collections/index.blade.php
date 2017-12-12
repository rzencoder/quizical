@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Latest Quizzes</div>
                @foreach($collections as $collection)
                    @for($i = 0; $i < count($scores); $i++)
                        @if($scores[$i]->collection_id === $collection ->id)
                            <div class="panel-body">
                                <div> {{ $collection->collection }} 
                                     <span>Score: {{ $scores[$i]->score }}</span>
                                </div>                     
                            </div>
                            <?php break;?>
                        @elseif($i === count($scores) - 1)
                            <div class="panel-body">
                                <a href="quizzes/quiz/{{$collection->id}}"> {{ $collection->collection }} </a>
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
