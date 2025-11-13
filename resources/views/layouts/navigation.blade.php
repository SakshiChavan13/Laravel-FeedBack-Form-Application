<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-lg font-bold">Feedback App</a>
                </div>

                <!-- Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.questions.index') }}" class="text-gray-700 hover:text-indigo-600">
                                Manage Questions
                            </a>
                            <a href="{{ route('admin.feedback.answers') }}" class="text-gray-700 hover:text-indigo-600">
                                View Responses
                            </a>
                        @else
                            <a href="{{ route('feedback.index') }}" class="text-gray-700 hover:text-indigo-600">
                                Submit Feedback
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <span class="mr-4">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
