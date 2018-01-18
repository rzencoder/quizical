@if(Auth::guard('web')->check())
    <p class="text-success">
        You are logged in as a <strong>STUDENT</strong>
    </p>
@else
    <p class="text-danger">
        You logged out as a <strong>STUDENT</strong>
    </p>
@endif

@if(Auth::guard('admin')->check())
    <p class="text-success">
        You are logged in as a <strong>TEACHER</strong>
    </p>
@else
    <p class="text-danger">
        You logged out as a <strong>TEACHER</strong>
    </p>
@endif