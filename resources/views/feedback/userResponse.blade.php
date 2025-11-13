@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">
        Feedback from {{ $userAnswer->user->name }}
    </h1>

    @if(!$userAnswer)
        <div class="alert alert-info">
            No responses found for this user.
        </div>
    @else
        <div class="space-y-4">
           
                <div class="border p-4 rounded bg-white shadow-sm">
                    <p class="font-semibold text-gray-800 mb-1">
                        {{ $userAnswer->feedbackQuestion->title ?? 'N.A' }}
                    </p>

                    @if($userAnswer->feedbackQuestion->type === 'rating')
                        <p class="text-yellow-500">
                            ⭐ {{ $userAnswer->answer ?? 'N.A'}}/5
                        </p>
                    @else
                        <p class="text-gray-700">
                            {{ $userAnswer->answer ?: '— No answer provided —' }}
                        </p>
                    @endif
                </div>
           
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.feedback.answers') }}" 
           class="inline-block text-indigo-600 hover:underline">
           ← Back to All Responses
        </a>
    </div>
</div>
@endsection
