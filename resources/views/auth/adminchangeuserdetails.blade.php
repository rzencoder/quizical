@extends('layouts.app')
 
@section('content')

<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">Change Details</div>

        <div class="panel-body">
            @component('components.messages')
            
            @endcomponent
            <form class="form-horizontal" method="POST" action="{{ route('admin.changeUserDetails') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                    <label for="new-password" class="col-md-4 control-label">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="current-password" type="password" class="form-control" name="current-password" required>

                        @if ($errors->has('current-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current-password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Update Details
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection