<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackQuestion;

class FeedbackController extends Controller
{
    public function index()
    {
        $questions = FeedbackQuestion::where('is_active', true)->get();
        return view('feedback.index', compact('questions'));
    }


    public function submit(Request $request)
    {
        $data = $request->validate([
            'answers' => 'required|array',
            'answers.*.feedback_question_id' => 'required|exists:feedback_questions,id',
            'answers.*.answer' => 'nullable|string',
        ]);


        $user = auth()->user();


        foreach ($data['answers'] as $ans) {
            FeedbackAnswer::create([
                'user_id' => $user->id,
                'feedback_question_id' => $ans['feedback_question_id'],
                'answer' => $ans['answer'] ?? '',
            ]);
        }


        return response()->json(['success' => true, 'message' => 'Thank you for your feedback']);
    }
}
