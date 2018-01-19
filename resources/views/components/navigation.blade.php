<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand nav-title" href="/">QUIZICAL</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">                       
                @guest
                    <li><a href="{{ route('login') }}">Student</a></li>
                    <li><a href="{{ route('admin.login') }}">Teacher</a></li>
                @else
                    @if(Auth::guard('admin')->check())
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                                Logout
                            </a>
                            <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-user').submit();">
                                Logout
                            </a>
                            <form id="logout-form-user" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif                 
                @endguest
            </ul>
        </div>
    </div>
</nav>