@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h4>Feedback Questions</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#questionModal">Create Question</button>
        </div>

        <table class="table table-bordered" id="questionsTable">
            <thead>
                <tr>
                   <th>Sr.No</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Active</th>
                    <th>Required</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="questionForm">
                @csrf
                <input type="hidden" id="question_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="questionModalLabel">Create Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="rating">Rating</option>
                            </select>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_required" name="is_required">
                            <label class="form-check-label" for="is_required">Required</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
     
$(document).ready(function () {
    
    
    

    // Ensure Laravel detects AJAX
    $.ajaxSetup({
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    });

    // Test modal opening
    $(document).on('click', '[data-bs-toggle="modal"]', function() {
        console.log('Modal toggle clicked');
        console.log('Target:', $(this).data('bs-target'));
    });

    fetchQuestions();

    // ---------------------------
    // Fetch Questions List
    // ---------------------------
    function fetchQuestions() {
        console.log('Fetching questions...');
        $.ajax({
           url: "{{ route('admin.questions.response') }}", // Use the proper route
            method: "GET",
            success: function (data) {
               
                let rows = "";

                // Handle both formats - either data.questions or just data
                const questions = data.questions || data;
                
                $.each(questions, function (i, question) {
                    rows += `
                        <tr>
                            <td>${question.id}</td>
                            <td>${question.title}</td>
                            <td>${question.type}</td>
                            <td>${question.is_active ? 'Yes' : 'No'}</td>
                            <td>${question.is_required ? 'Yes' : 'No'}</td>
                            <td>
                                <button class="btn btn-sm btn-info edit-btn" data-id="${question.id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${question.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });

                $("#questionsTable tbody").html(rows);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching questions:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
                console.log('URL tried:', "{{ route('admin.questions.index') }}");
            }
        });
    }

    // ---------------------------
    // Create / Update
    // ---------------------------
    $("#questionForm").on("submit", function (e) {
        e.preventDefault();
       
        let id = $("#question_id").val();
        let url = id ? `/admin/questions/${id}` : `/admin/questions`;
        let method = id ? "PUT" : "POST";

     
        $.ajax({
            url: url,
            type: method,
            data: {
                _token: '{{ csrf_token() }}',
                title: $("#title").val(),
                type: $("#type").val(),
                is_active: $("#is_active").is(":checked") ? 1 : 0,
                is_required: $("#is_required").is(":checked") ? 1 : 0
            },
            success: function (response) {
              
                $("#questionModal").modal("hide");
                $("#questionForm")[0].reset();
                $("#question_id").val("");
                fetchQuestions();
            },
            error: function(xhr, status, error) {
                console.error('Error saving question:', error);
                console.log('Response:', xhr.responseText);
            }
        });
    });

    // ---------------------------
    // Edit Question
    // ---------------------------
    $(document).on("click", ".edit-btn", function () {
        let id = $(this).data("id");
       

        $.get(`/admin/questions/${id}`, function (question) {
            
            $("#question_id").val(question.id);
            $("#title").val(question.title);
            $("#type").val(question.type);
            $("#is_active").prop("checked", question.is_active);
            $("#is_required").prop("checked", question.is_required);
            
            // Update modal title for editing
            $("#questionModalLabel").text("Edit Question");
            $("#questionModal").modal("show");
        }).fail(function(xhr, status, error) {
            console.error('Error fetching question for edit:', error);
        });
    });

    // ---------------------------
    // Delete Question
    // ---------------------------
    $(document).on("click", ".delete-btn", function () {
        if (!confirm("Are you sure?")) return;

        let id = $(this).data("id");
        
        $.ajax({
            url: `/admin/questions/${id}`,
            type: "DELETE",
            data: { 
                _token: '{{ csrf_token() }}' 
            },
            success: function (response) {
                console.log('Question deleted successfully:', response);
                fetchQuestions();
            },
            error: function(xhr, status, error) {
                console.error('Error deleting question:', error);
                console.log('Response:', xhr.responseText);
            }
        });
    });

  

    $('#questionModal').on('hidden.bs.modal', function () {
      
        $("#questionModalLabel").text("Create Question");
        $("#questionForm")[0].reset();
        $("#question_id").val("");
    });

});
</script>
@endpush