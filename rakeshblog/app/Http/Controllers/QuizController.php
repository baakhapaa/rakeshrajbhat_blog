<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserQuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Submit quiz answers
     */
    public function submit(Request $request, $quizId)
    {
        // Debug: Log the request
        \Log::info('Quiz submitted for user: ' . Auth::id());
        \Log::info('Answers:', $request->all());
        
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $answers = $request->input('answers', []);
        
        // Debug: Log answers
        \Log::info('Answers array:', $answers);
        
        $score = 0;
        $total = $quiz->questions->count();
        $correctCount = 0;
        $details = [];
        
        // Map for user answers (0-3 to A-D)
        $userOptions = [
            0 => 'A',
            1 => 'B',
            2 => 'C',
            3 => 'D',
        ];
        
        // Map for correct answers (1-4 to A-D)
        $correctOptions = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
        ];
        
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            
            $isCorrect = false;
            if ($userAnswer !== null) {
                $userLetter = $userOptions[(int)$userAnswer] ?? 'Unknown';
                $correctLetter = $correctOptions[(int)$question->correct_answer] ?? 'Unknown';
                $isCorrect = $userLetter === $correctLetter;
            }
            
            if ($isCorrect) {
                $correctCount++;
                $score += $question->points;
            }
            
            $details[] = [
                'question' => $question->question,
                'user_answer' => $userAnswer !== null ? ($userOptions[(int)$userAnswer] ?? 'Not answered') : 'Not answered',
                'correct_answer' => $correctOptions[(int)$question->correct_answer] ?? 'Unknown',
                'correct' => $isCorrect,
                'points' => $question->points,
            ];
        }
        
        $percentage = $total > 0 ? round(($correctCount / $total) * 100) : 0;
        $passed = $percentage >= $quiz->passing_score;
        
        // Calculate points earned (bonus for passing)
        $pointsEarned = $score;
        if ($passed) {
            $pointsEarned += 10; // Bonus points for passing
        }
        
        // Debug: Log points
        \Log::info('Points earned: ' . $pointsEarned);
        \Log::info('Correct count: ' . $correctCount);
        \Log::info('Total questions: ' . $total);
        
        // ========================================== */
        // SAVE TO DATABASE - FIXED
        // ========================================== */
        if (Auth::check()) {
            $user = Auth::user();
            
            // Debug: Log user before update
            \Log::info('User before update - total_points: ' . ($user->total_points ?? 0));
            
            // Save quiz result
            UserQuizResult::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
                'correct_count' => $correctCount,
                'total_questions' => $total,
                'percentage' => $percentage,
                'passed' => $passed,
                'points_earned' => $pointsEarned,
            ]);
            
            // Update user stats
            $user->total_points = ($user->total_points ?? 0) + $pointsEarned;
            $user->quiz_attempts = ($user->quiz_attempts ?? 0) + 1;
            $user->correct_answers = ($user->correct_answers ?? 0) + $correctCount;
            $user->total_questions_answered = ($user->total_questions_answered ?? 0) + $total;
            $user->save();
            
            // Debug: Log user after update
            \Log::info('User after update - total_points: ' . ($user->total_points ?? 0));
            \Log::info('Quiz attempt saved successfully for user: ' . $user->id);
        } else {
            \Log::warning('User not authenticated for quiz submission');
        }
        
        // Store results in session
        session([
            'quiz_completed' => true,
            'quiz_results' => [
                'score' => $score,
                'correct' => $correctCount,
                'total' => $total,
                'percentage' => $percentage,
                'passed' => $passed,
                'passing_score' => $quiz->passing_score,
                'points_earned' => $pointsEarned,
                'details' => $details,
            ]
        ]);
        
        return redirect()->back()->with('success', 'Quiz submitted successfully! You earned ' . $pointsEarned . ' points!');
    }
}