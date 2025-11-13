<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackQuestion;
use App\Http\Controllers\Controller;

class FeedbackQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
        $questions = FeedbackQuestion::latest()->get();
       
        return response()->json(['questions' => $questions]);
    }
     
    return view('admin.questions.index');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'is_active' => 'nullable|boolean',
            'is_required' => 'nullable|boolean',
        ]);

        $question = FeedbackQuestion::create($data);


        return response()->json(['success' => true, 'question' => $question]);
    }


    public function show(FeedbackQuestion $question)
    {
        return response()->json($question);
    }


    public function update(Request $request, FeedbackQuestion $question)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'is_active' => 'nullable|boolean',
            'is_required' => 'nullable|boolean',
        ]);


        $question->update($data);
        return response()->json(['success' => true, 'question' => $question]);
    }


    public function destroy(FeedbackQuestion $question)
    {
        $question->delete();
        return response()->json(['success' => true]);
    }


   
    public function answers(Request $request)
    {
         $responses = FeedbackAnswer::with(['user', 'feedBackQuestion'])
            ->latest()
            ->get()
            ->groupBy('user_id'); // group answers by user

        return view('admin.responses.index', compact('responses'));
    }

    public function showSingleResponse(Request $request, $userId)
    {
         $userAnswer = FeedbackAnswer::with(['user', 'feedbackQuestion'])
            ->where('user_id', $userId)
            ->latest()
            ->get()
            ->first();
            //dd($userAnswer);
            
 // group answers by user

        return view('feedback.userResponse', compact('userAnswer'));
    }
}
