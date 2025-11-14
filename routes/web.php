<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FeedbackQuestionController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Feedback
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback/submit', [FeedbackController::class, 'submit'])->name('feedback.submit');

    // View own submitted feedback
    Route::get('user-response/{user}', [FeedbackQuestionController::class, 'showSingleResponse'])
        ->name('feedback.responses.show');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Feedback Questions CRUD
        Route::resource('questions', FeedbackQuestionController::class);
        Route::get('question/responses', [FeedbackQuestionController::class, 'questionResponse'])
            ->name('questions.response');
        // View all users' feedback
        Route::get('feedback-answers', [FeedbackQuestionController::class, 'answers'])
            ->name('feedback.answers');
    });


require __DIR__ . '/auth.php';
