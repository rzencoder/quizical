@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-default">
                <present  :timerange={{ $time }}></present>
            </div>
        </div>
    </div>
</div>
@endsection
