<?php

use App\Models\FeedbackQuestion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackQuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback/submit', [FeedbackController::class, 'submit'])->name('feedback.submit');

});
Route::get('/questions', [FeedbackQuestionController::class, 'index'])->name('admin.questions.index');
Route::post('admin/questions', [FeedbackQuestionController::class, 'store'])->name('admin.questions.store');
Route::get('admin/questions/{question}', [FeedbackQuestionController::class, 'show'])->name('admin.questions.show');
Route::put('admin/questions/{question}', [FeedbackQuestionController::class, 'update'])->name('admin.questions.update');
Route::delete('admin/questions/{question}', [FeedbackQuestionController::class, 'destroy'])->name('admin.questions.destroy');


Route::get('user-response/{user}', [FeedbackQuestionController::class, 'showSingleResponse'])->name('feedback.responses.show');

// Admin routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('questions', [FeedbackQuestionController::class, 'index'])->name('admin.questions.index');
   
    Route::get('questions/list', function () {
        return FeedbackQuestion::latest()->get();
    })->name('admin.questions.list');
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
  
    Route::resource('feedback-questions', FeedbackQuestionController::class)->except(['create', 'edit']);
    
    Route::get('feedback-answers', [FeedbackQuestionController::class, 'answers'])->name('feedback.answers');

});

require __DIR__ . '/auth.php';
