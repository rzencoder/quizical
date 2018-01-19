@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="panel-body">
        @component('components.messages')
                
        @endcomponent              
    </div>
    <questions></questions>        
</div>

@endsection
