@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">User Feedback Responses</h1>

    @if($responses->isEmpty())
        <div class="alert alert-info">No feedback responses found yet.</div>
    @else
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">User</th>
                   
                    <th class="border px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($responses as $userId => $answers)
                    @php $user = $answers->first()->user; @endphp
                    <tr>
                        <td class="border px-4 py-2">{{ $user->name ?? 'Unknown User' }}</td>
                        
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('feedback.responses.show', $user->id) }}"
                               class="text-indigo-600 hover:underline">
                               View Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
