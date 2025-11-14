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
                    <div class="mb-4 question-block" data-required="{{ $q->is_required }}" data-id="{{ $q->id }}">
                        <label class="block font-medium text-gray-700 mb-1">
                            {{ $q->title }}
                            @if($q->is_required)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        <input type="hidden" 
                               name="answers[{{ $q->id }}][feedback_question_id]" 
                               value="{{ $q->id }}">

                        @switch($q->type)
                            @case('text')
                                <input type="text"
                                       class="answer-input form-control w-full rounded border-gray-300"
                                       name="answers[{{ $q->id }}][answer]"
                                       placeholder="Type your answer here...">
                                @break

                            @case('textarea')
                                <textarea class="answer-input form-control w-full rounded border-gray-300"
                                          name="answers[{{ $q->id }}][answer]"
                                          rows="2"
                                          placeholder="Type your answer here..."></textarea>
                                @break


                            @default
                                <textarea class="answer-input form-control w-full rounded border-gray-300"
                                          name="answers[{{ $q->id }}][answer]"
                                          rows="2"></textarea>
                        @endswitch

                        <div class="text-red-500 text-sm mt-1 error-message" style="display:none;">
                            This field is required.
                        </div>
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

        // RESET ALL ERRORS
        $('.error-message').hide();
        $('.answer-input').removeClass('border-red-500');

        let errorMessages = [];
        let hasError = false;
        let questionsData = @json($questions);

        // ---------------- FRONTEND VALIDATION ----------------
        questionsData.forEach(q => {

            let block = $(`.question-block[data-id="${q.id}"]`);

            let input = block.find('.answer-input');
            let value = input.val();

            // Only validate if required
            if (q.is_required && (!value || value.trim() === "")) {

                hasError = true;

                block.find('.error-message').show();
                input.addClass('border-red-500');

                errorMessages.push(q.title);
            }
        });

        
        if (hasError) {
            alert("⚠️ Please fill all required fields:\n\n" + errorMessages.join("\n"));
            return;
        }

       
        $('#submitBtn').attr('disabled', true).text('Submitting...');

        $.post("{{ route('feedback.submit') }}", $(this).serialize())
            .done(function (res) {
                if (res.success) {
                    alert('✅ ' + res.message);
                    $('#feedbackForm')[0].reset();
                }
            })
            .fail(function (xhr) {
                alert("⚠️ Something went wrong. Please try again.");
            })
            .always(function () {
                $('#submitBtn').attr('disabled', false).text('Submit Feedback');
            });
    });
});
</script>
@endsection
