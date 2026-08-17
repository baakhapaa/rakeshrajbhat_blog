<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('quiz')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            // Single question quiz (backward compatibility)
            'quiz_question' => 'nullable|string|max:500',
            'quiz_option_1' => 'nullable|string|max:255',
            'quiz_option_2' => 'nullable|string|max:255',
            'quiz_option_3' => 'nullable|string|max:255',
            'quiz_option_4' => 'nullable|string|max:255',
            'quiz_correct_answer' => 'nullable|integer|min:1|max:4',
            // New multi-question quiz validation
            'quiz_title' => 'nullable|string|max:255',
            'quiz_description' => 'nullable|string',
            'quiz_passing_score' => 'nullable|integer|min:0|max:100',
            'quiz_is_active' => 'nullable|boolean',
            'questions' => 'nullable|array',
            'questions.*.question' => 'nullable|string',
            'questions.*.option_1' => 'nullable|string',
            'questions.*.option_2' => 'nullable|string',
            'questions.*.option_3' => 'nullable|string',
            'questions.*.option_4' => 'nullable|string',
            'questions.*.correct_answer' => 'nullable|integer|min:1|max:4',
            'questions.*.points' => 'nullable|integer|min:0|max:20000',
        ]);

        // Check if quiz title is provided but no questions
        if ($request->filled('quiz_title')) {
            $hasQuestions = $request->has('questions') && count($request->questions) > 0;
            $hasValidQuestion = false;
            
            if ($hasQuestions) {
                foreach ($request->questions as $q) {
                    if (!empty($q['question']) && !empty($q['option_1']) && !empty($q['correct_answer'])) {
                        $hasValidQuestion = true;
                        break;
                    }
                }
            }
            
            if (!$hasValidQuestion) {
                return back()
                    ->withErrors(['questions' => 'Please add at least one valid question with all fields filled.'])
                    ->withInput();
            }
        }

        $content = html_entity_decode($validated['content']);
        $excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($content), 150);

        $tags = [];
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $featuredImage = $request->featured_image ?? null;

        // Generate a unique slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $isPublished = $request->has('is_published') && $request->is_published == 1;
        $publishedAt = $isPublished ? now() : null;

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'category' => $validated['category'] ?? 'General',
            'tags' => $tags,
            'featured_image' => $featuredImage,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
            'author' => auth()->guard('admin')->user()->name ?? 'Admin',
            // Single question quiz fields (backward compatibility)
            'quiz_question' => $validated['quiz_question'] ?? null,
            'quiz_option_1' => $validated['quiz_option_1'] ?? null,
            'quiz_option_2' => $validated['quiz_option_2'] ?? null,
            'quiz_option_3' => $validated['quiz_option_3'] ?? null,
            'quiz_option_4' => $validated['quiz_option_4'] ?? null,
            'quiz_correct_answer' => $validated['quiz_correct_answer'] ?? null,
        ]);

        // Handle multi-question quiz
        $this->handleQuizCreation($request, $blog);

        return redirect()->route('admin.blogs.edit', $blog->id)
            ->with('success', 'Blog created successfully with quiz!');
    }

    public function show($id)
    {
        $blog = Blog::with(['quiz.questions'])->findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Blog::with(['quiz.questions'])->findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            // Single question quiz (backward compatibility)
            'quiz_question' => 'nullable|string|max:500',
            'quiz_option_1' => 'nullable|string|max:255',
            'quiz_option_2' => 'nullable|string|max:255',
            'quiz_option_3' => 'nullable|string|max:255',
            'quiz_option_4' => 'nullable|string|max:255',
            'quiz_correct_answer' => 'nullable|integer|min:1|max:4',
            // New multi-question quiz validation
            'quiz_title' => 'nullable|string|max:255',
            'quiz_description' => 'nullable|string',
            'quiz_passing_score' => 'nullable|integer|min:0|max:100',
            'quiz_is_active' => 'nullable|boolean',
            'remove_quiz' => 'nullable|boolean',
            'questions' => 'nullable|array',
            'questions.*.id' => 'nullable|exists:quiz_questions,id',
            'questions.*.question' => 'nullable|string',
            'questions.*.option_1' => 'nullable|string',
            'questions.*.option_2' => 'nullable|string',
            'questions.*.option_3' => 'nullable|string',
            'questions.*.option_4' => 'nullable|string',
            'questions.*.correct_answer' => 'nullable|integer|min:1|max:4',
            'questions.*.points' => 'nullable|integer|min:0|max:20000',
        ]);

        // Check if quiz title is provided but no questions
        if ($request->filled('quiz_title') && !$request->has('remove_quiz')) {
            $hasQuestions = $request->has('questions') && count($request->questions) > 0;
            $hasValidQuestion = false;
            
            if ($hasQuestions) {
                foreach ($request->questions as $q) {
                    if (!empty($q['question']) && !empty($q['option_1']) && !empty($q['correct_answer'])) {
                        $hasValidQuestion = true;
                        break;
                    }
                }
            }
            
            if (!$hasValidQuestion) {
                return back()
                    ->withErrors(['questions' => 'Please add at least one valid question with all fields filled.'])
                    ->withInput();
            }
        }

        $content = html_entity_decode($validated['content']);
        $excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($content), 150);

        $tags = [];
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $featuredImage = $request->featured_image ?? null;

        // Generate a unique slug (except for the current blog)
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $isPublished = $request->has('is_published') && $request->is_published == 1;
        $publishedAt = $isPublished ? now() : null;

        // Delete old image if new one is uploaded
        if ($featuredImage && $blog->featured_image && $featuredImage !== $blog->featured_image) {
            $oldPath = str_replace('/storage/', '', $blog->featured_image);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $blog->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'category' => $validated['category'] ?? 'General',
            'tags' => $tags,
            'featured_image' => $featuredImage,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
            // Single question quiz fields (backward compatibility)
            'quiz_question' => $validated['quiz_question'] ?? null,
            'quiz_option_1' => $validated['quiz_option_1'] ?? null,
            'quiz_option_2' => $validated['quiz_option_2'] ?? null,
            'quiz_option_3' => $validated['quiz_option_3'] ?? null,
            'quiz_option_4' => $validated['quiz_option_4'] ?? null,
            'quiz_correct_answer' => $validated['quiz_correct_answer'] ?? null,
        ]);

        // Handle quiz removal
        if ($request->has('remove_quiz') && $request->remove_quiz == 1) {
            $this->deleteQuiz($blog);
            return redirect()->route('admin.blogs.edit', $blog->id)
                ->with('success', 'Blog updated successfully! Quiz removed.');
        }

        // ========================================== */
        // FIXED: ONLY HANDLE QUIZ IF QUIZ_TITLE IS PROVIDED
        // ========================================== */
        if ($request->filled('quiz_title')) {
            $this->handleQuizUpdate($request, $blog);
        }
        // If quiz_title is empty, KEEP the existing quiz (don't delete it)

        return redirect()->route('admin.blogs.edit', $blog->id)
            ->with('success', 'Blog and quiz updated successfully!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        
        // Delete featured image if exists
        if ($blog->featured_image) {
            $path = str_replace('/storage/', '', $blog->featured_image);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        
        // Delete associated quiz and questions
        $this->deleteQuiz($blog);
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully!');
    }

    /**
     * Handle quiz creation for new blog
     */
    private function handleQuizCreation(Request $request, Blog $blog)
    {
        // Check if quiz data is present
        if (!$request->filled('quiz_title')) {
            return;
        }

        // Create quiz
        $quiz = Quiz::create([
            'blog_id' => $blog->id,
            'title' => $request->quiz_title,
            'description' => $request->quiz_description ?? null,
            'passing_score' => $request->quiz_passing_score ?? 60,
            'is_active' => $request->has('quiz_is_active') && $request->quiz_is_active == 1,
        ]);

        // Create questions
        if ($request->has('questions')) {
            foreach ($request->questions as $index => $questionData) {
                // Skip empty questions
                if (empty($questionData['question']) || empty($questionData['option_1']) || empty($questionData['correct_answer'])) {
                    continue;
                }

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'option_1' => $questionData['option_1'],
                    'option_2' => $questionData['option_2'] ?? '',
                    'option_3' => $questionData['option_3'] ?? '',
                    'option_4' => $questionData['option_4'] ?? '',
                    'correct_answer' => (int) $questionData['correct_answer'],
                    'points' => (int) ($questionData['points'] ?? 10),
                    'order' => $index,
                ]);
            }
        }
    }

    /**
     * Handle quiz update for existing blog
     */
    private function handleQuizUpdate(Request $request, Blog $blog)
    {
        // Check if quiz data is present
        if (!$request->filled('quiz_title')) {
            // FIXED: Don't delete quiz, just return
            return;
        }

        // Create or update quiz
        $quiz = $blog->quiz;
        if ($quiz) {
            $quiz->update([
                'title' => $request->quiz_title,
                'description' => $request->quiz_description ?? null,
                'passing_score' => $request->quiz_passing_score ?? 60,
                'is_active' => $request->has('quiz_is_active') && $request->quiz_is_active == 1,
            ]);
        } else {
            $quiz = Quiz::create([
                'blog_id' => $blog->id,
                'title' => $request->quiz_title,
                'description' => $request->quiz_description ?? null,
                'passing_score' => $request->quiz_passing_score ?? 60,
                'is_active' => $request->has('quiz_is_active') && $request->quiz_is_active == 1,
            ]);
        }

        // Handle questions - update or create
        if ($request->has('questions')) {
            // Get existing question IDs
            $existingQuestionIds = $quiz->questions()->pluck('id')->toArray();
            $updatedQuestionIds = [];

            foreach ($request->questions as $index => $questionData) {
                // Skip empty questions
                if (empty($questionData['question']) || empty($questionData['option_1']) || empty($questionData['correct_answer'])) {
                    continue;
                }

                // Prepare question data
                $questionFields = [
                    'question' => $questionData['question'],
                    'option_1' => $questionData['option_1'],
                    'option_2' => $questionData['option_2'] ?? '',
                    'option_3' => $questionData['option_3'] ?? '',
                    'option_4' => $questionData['option_4'] ?? '',
                    'correct_answer' => (int) $questionData['correct_answer'],
                    'points' => (int) ($questionData['points'] ?? 10),
                    'order' => $index,
                ];

                // Check if updating existing question
                if (isset($questionData['id']) && $questionData['id']) {
                    $question = QuizQuestion::find($questionData['id']);
                    if ($question && $question->quiz_id == $quiz->id) {
                        $question->update($questionFields);
                        $updatedQuestionIds[] = $question->id;
                        continue;
                    }
                }

                // Create new question
                $newQuestion = QuizQuestion::create(array_merge($questionFields, ['quiz_id' => $quiz->id]));
                $updatedQuestionIds[] = $newQuestion->id;
            }

            // Delete questions that were removed
            $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
            if (!empty($questionsToDelete)) {
                QuizQuestion::whereIn('id', $questionsToDelete)->delete();
            }
        }
    }

    /**
     * Delete quiz and its questions
     */
    private function deleteQuiz(Blog $blog)
    {
        if ($blog->quiz) {
            $blog->quiz->questions()->delete();
            $blog->quiz()->delete();
        }
    }

    /**
     * Toggle blog publish status
     */
    public function togglePublish($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->is_published = !$blog->is_published;
        $blog->published_at = $blog->is_published ? now() : null;
        $blog->save();

        return redirect()->back()->with('success', 
            $blog->is_published ? 'Blog published!' : 'Blog unpublished!'
        );
    }
}