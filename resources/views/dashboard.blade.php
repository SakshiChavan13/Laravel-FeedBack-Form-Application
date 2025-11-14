
@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->is_admin)
                       Welcome to Admin Dashboard
                    @else
                    
                       Welcome to User Dashboard
                    @endif
                </div>

            </div>
        </div>
    </div>
    @endsection

