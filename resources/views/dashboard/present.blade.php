@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="panel panel-default">
        @component('components.messages')
                    
        @endcomponent
        <present  :timerange={{ $time }}></present>
    </div>
</div>

@endsection
