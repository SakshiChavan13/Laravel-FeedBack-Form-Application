@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">

    @php
        $first = $userAnswer->first(); // first answer in the group
        $user = $first->user ?? null;
    @endphp

    @if(auth()->user()->is_admin)
        <h1 class="text-2xl font-semibold mb-4">
            Feedback from {{ $user->name }}
        </h1>
    @else
        <h1 class="text-2xl font-semibold mb-4">
            Your Response
        </h1>
    @endif

    @if(!$userAnswer || $userAnswer->isEmpty())
        <div class="alert alert-info">
            No responses found for this user.
        </div>
    @else
        <div class="space-y-4">
            @foreach($userAnswer as $answer)
                <div class="border p-4 rounded bg-white shadow-sm">
                    <p class="font-semibold text-gray-800 mb-1">
                        {{ $answer->feedbackQuestion->title ?? 'N.A' }}
                    </p>

                    @if($answer->feedbackQuestion->type === 'rating')
                        <p class="text-yellow-500">
                            ⭐ {{ $answer->answer ?? 'N.A' }}/5
                        </p>
                    @else
                        <p class="text-gray-700">
                            {{ $answer->answer ?: '— No answer provided —' }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if(auth()->user()->is_admin)
        <div class="mt-6">
            <a href="{{ route('admin.feedback.answers') }}" 
               class="inline-block text-indigo-600 hover:underline">
               ← Back to All Responses
            </a>
        </div>
    @endif
</div>

@endsection
