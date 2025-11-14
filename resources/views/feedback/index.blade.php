@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Feedback Form</h1>

    @if($questions->isEmpty())
        <div class="alert alert-info">No feedback questions available at the moment.</div>
    @else
        <form id="feedbackForm">
            @csrf
            <div id="questions">
                @foreach($questions as $q)
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-1">
                            {{ $q->title }}
                        </label>
                        <input type="hidden" name="answers[{{ $q->id }}][question_id]" value="{{ $q->id }}">

                        @switch($q->type)
                            @case('text')
                                <input type="text"
                                       name="answers[{{ $q->id }}][answer]"
                                       class="form-control w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Type your answer here...">
                                @break

                            @case('textarea')
                                <textarea name="answers[{{ $q->id }}][answer]"
                                          class="form-control w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                          rows="2"
                                          placeholder="Type your answer here..."></textarea>
                                @break

                            @case('radio')
                                <div>
                                    <label><input type="radio" name="answers[{{ $q->id }}][answer]" value="Yes"> Yes</label>
                                    <label class="ms-3"><input type="radio" name="answers[{{ $q->id }}][answer]" value="No"> No</label>
                                </div>
                                @break

                            @case('select')
                                <select name="answers[{{ $q->id }}][answer]" class="form-control">
                                    <option value="">Select...</option>
                                    <option value="Excellent">Excellent</option>
                                    <option value="Good">Good</option>
                                    <option value="Average">Average</option>
                                    <option value="Poor">Poor</option>
                                </select>
                                @break

                            @default
                                <textarea name="answers[{{ $q->id }}][answer]"
                                          class="form-control w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                          rows="2"
                                          placeholder="Type your answer here..."></textarea>
                        @endswitch
                    </div>
                @endforeach
            </div>

            <button type="submit" id="submitBtn"
                class="btn btn-primary bg-indigo-600 text-white px-4 py-2 rounded">
                Submit Feedback
            </button>
        </form>

        <div id="feedbackResult" class="mt-4"></div>
    @endif
</div>

<script>
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#feedbackForm').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);

        $('#submitBtn').attr('disabled', true).text('Submitting...');

        $.post("{{ route('feedback.submit') }}", form.serialize())
            .done(function (res) {
                if (res.success) {
                    alert('✅ ' + res.message);
                    form[0].reset();
                }
            })
            .fail(function (xhr) {
                let msg = 'Something went wrong. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                alert('⚠️ ' + msg);
            })
            .always(function () {
                $('#submitBtn').attr('disabled', false).text('Submit Feedback');
            });
    });
});
</script>
@endsection
