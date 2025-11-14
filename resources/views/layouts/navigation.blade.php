<nav class="navbar-custom">
    <div class="nav-title">Feedback App</div>

    <div class="nav-links">
        @if(auth()->user()->is_admin)
            <a href="{{ route('admin.questions.index') }}">Manage Questions</a>
            <a href="{{ route('admin.feedback.answers') }}">View Responses</a>
        @else
            <a href="{{ route('feedback.index') }}">Feedback Form</a>
            <a href="{{ route('feedback.responses.show', auth()->id()) }}">My Response</a>
        @endif
    </div>

    <div class="nav-user">
        {{ auth()->user()->name }}
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout-btn">Logout</button>
    </form>
</nav>
