@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <present  :timerange={{ $time }}></present>
            </div>
        </div>
    </div>
</div>
@endsection
