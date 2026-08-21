<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\UserQuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminQuizController extends Controller
{
    /**
     * Display a specific quiz for taking.
     */
    public function show($quizId)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);
        
        // Check if user has already completed this quiz1
        $completed = false;
        $previousResult = null;
        
        if (Auth::check()) {
            $previousResult = UserQuizResult::where('user_id', Auth::id())
                ->where('quiz_id', $quizId)
                ->latest()
                ->first();
            
            if ($previousResult) {
                $completed = true;
            }
        }
        
        return view('frontend.quiz.take', compact('quiz', 'completed', 'previousResult'));
    }

    /**
     * Submit quiz answers
     */
    public function submit(Request $request, $quizId)
    {
        // Debug logging
        Log::info('=== QUIZ SUBMISSION START ===');
        Log::info('User ID: ' . Auth::id());
        Log::info('Quiz ID: ' . $quizId);
        Log::info('Answers:', $request->all());

        try {
            // Validate quiz exists
            $quiz = Quiz::with('questions')->findOrFail($quizId);
            
            // Check if user already completed this quiz
            if (Auth::check()) {
                $existingResult = UserQuizResult::where('user_id', Auth::id())
                    ->where('quiz_id', $quizId)
                    ->exists();
                
                if ($existingResult) {
                    return redirect()->back()
                        ->with('error', 'You have already completed this quiz!');
                }
            }
            
            // Validate answers
            $validator = Validator::make($request->all(), [
                'answers' => 'required|array',
                'answers.*' => 'nullable|in:0,1,2,3', // 0=A, 1=B, 2=C, 3=D
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $answers = $request->input('answers', []);
            
            // Check if all questions are answered
            $totalQuestions = $quiz->questions->count();
            $answeredCount = count(array_filter($answers));
            
            if ($answeredCount < $totalQuestions) {
                return redirect()->back()
                    ->with('error', 'Please answer all questions before submitting.')
                    ->withInput();
            }

            $score = 0;
            $total = $quiz->questions->count();
            $correctCount = 0;
            $details = [];
            $wrongQuestions = [];
            
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
                $userLetter = 'Not answered';
                $correctLetter = 'Unknown';
                
                if ($userAnswer !== null && isset($userOptions[(int)$userAnswer])) {
                    $userLetter = $userOptions[(int)$userAnswer];
                    $correctLetter = $correctOptions[(int)$question->correct_answer] ?? 'Unknown';
                    $isCorrect = $userLetter === $correctLetter;
                }
                
                if ($isCorrect) {
                    $correctCount++;
                    $score += $question->points ?? 10;
                } else {
                    $wrongQuestions[] = [
                        'question' => $question->question,
                        'your_answer' => $userLetter,
                        'correct_answer' => $correctLetter,
                    ];
                }
                
                $details[] = [
                    'question_id' => $question->id,
                    'question' => $question->question,
                    'user_answer' => $userLetter,
                    'correct_answer' => $correctLetter,
                    'correct' => $isCorrect,
                    'points' => $question->points ?? 10,
                ];
            }
            
            $percentage = $total > 0 ? round(($correctCount / $total) * 100) : 0;
            $passingScore = $quiz->passing_score ?? 60;
            $passed = $percentage >= $passingScore;
            
            // Calculate points earned (bonus for passing)
            $pointsEarned = $score;
            if ($passed) {
                $pointsEarned += 10; // Bonus points for passing
            }
            
            Log::info('Score: ' . $score);
            Log::info('Correct Count: ' . $correctCount);
            Log::info('Points Earned: ' . $pointsEarned);
            
            // ==========================================
            // SAVE TO DATABASE
            // ==========================================
            if (Auth::check()) {
                $user = Auth::user();
                
                Log::info('User before update - total_points: ' . ($user->total_points ?? 0));
                Log::info('User before update - quiz_attempts: ' . ($user->quiz_attempts ?? 0));
                
                // Save quiz result
                try {
                    $result = UserQuizResult::create([
                        'user_id' => $user->id,
                        'quiz_id' => $quiz->id,
                        'score' => $score,
                        'correct_count' => $correctCount,
                        'total_questions' => $total,
                        'percentage' => $percentage,
                        'passed' => $passed,
                        'points_earned' => $pointsEarned,
                        'answers' => json_encode($answers),
                        'details' => json_encode($details),
                        'wrong_questions' => json_encode($wrongQuestions),
                    ]);
                    Log::info('UserQuizResult created with ID: ' . $result->id);
                } catch (\Exception $e) {
                    Log::error('Error saving UserQuizResult: ' . $e->getMessage());
                    return redirect()->back()
                        ->with('error', 'Failed to save quiz results. Please try again.');
                }
                
                // Update user stats
                try {
                    $user->total_points = ($user->total_points ?? 0) + $pointsEarned;
                    $user->quiz_attempts = ($user->quiz_attempts ?? 0) + 1;
                    $user->correct_answers = ($user->correct_answers ?? 0) + $correctCount;
                    $user->total_questions_answered = ($user->total_questions_answered ?? 0) + $total;
                    $user->save();
                    
                    Log::info('User after update - total_points: ' . ($user->total_points ?? 0));
                    Log::info('User after update - quiz_attempts: ' . ($user->quiz_attempts ?? 0));
                    Log::info('User after update - correct_answers: ' . ($user->correct_answers ?? 0));
                    Log::info('User after update - total_questions_answered: ' . ($user->total_questions_answered ?? 0));
                } catch (\Exception $e) {
                    Log::error('Error updating user stats: ' . $e->getMessage());
                    return redirect()->back()
                        ->with('error', 'Failed to update your stats. Please try again.');
                }
            } else {
                Log::warning('User not authenticated for quiz submission');
                return redirect()->route('login')
                    ->with('error', 'Please login to submit quiz results.');
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
                    'passing_score' => $passingScore,
                    'points_earned' => $pointsEarned,
                    'details' => $details,
                    'wrong_questions' => $wrongQuestions,
                ]
            ]);
            
            Log::info('=== QUIZ SUBMISSION END ===');
            
            $message = $passed 
                ? "🎉 Congratulations! You passed the quiz with {$percentage}% and earned {$pointsEarned} points!" 
                : "You scored {$percentage}%. You need {$passingScore}% to pass. Keep learning!";
            
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            Log::error('Quiz submission error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'An error occurred while submitting your quiz. Please try again.');
        }
    }

    /**
     * Reset quiz session data
     */
    public function reset()
    {
        session()->forget(['quiz_completed', 'quiz_results']);
        return response()->json(['success' => true]);
    }

    /**
     * Get quiz results for a user
     */
    public function getResults($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
        $results = UserQuizResult::where('user_id', $userId)
            ->with('quiz')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return response()->json($results);
    }

    /**
     * Get quiz statistics for a user
     */
    public function getStats($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        return response()->json([
            'total_points' => $user->total_points ?? 0,
            'quiz_attempts' => $user->quiz_attempts ?? 0,
            'correct_answers' => $user->correct_answers ?? 0,
            'total_questions_answered' => $user->total_questions_answered ?? 0,
            'accuracy' => $user->accuracy ?? '0%',
            'level' => $user->level ?? 'Beginner',
            'level_icon' => $user->level_icon ?? '🌱',
            'rank' => $user->rank ?? 0,
            'badges' => $user->badges ?? [],
        ]);
    }

    /**
     * Get leaderboard
     */
    public function leaderboard()
    {
        $topUsers = \App\Models\User::orderBy('total_points', 'desc')
            ->limit(100)
            ->get(['id', 'name', 'total_points', 'quiz_attempts', 'accuracy']);
        
        return response()->json([
            'users' => $topUsers->map(function($user, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $user->name,
                    'points' => $user->total_points ?? 0,
                    'quizzes' => $user->quiz_attempts ?? 0,
                    'accuracy' => $user->accuracy ?? '0%',
                ];
            })
        ]);
    }

    /**
     * Get quiz history for current user (for frontend)
     */
    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to view your quiz history.');
        }
        
        $results = UserQuizResult::where('user_id', Auth::id())
            ->with('quiz')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('frontend.quiz.history', compact('results'));
    }

    /**
     * Retake a quiz
     */
    public function retake($quizId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to retake the quiz.');
        }
        
        // Delete previous result for this quiz
        UserQuizResult::where('user_id', Auth::id())
            ->where('quiz_id', $quizId)
            ->delete();
        
        // Clear session
        session()->forget(['quiz_completed', 'quiz_results']);
        
        return redirect()->route('quiz.show', $quizId)
            ->with('success', 'You can now retake the quiz!');
    }
}