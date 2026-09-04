<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        // Filter by type
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'published':
                    $query->where('is_published', true);
                    break;
                case 'draft':
                    $query->where('is_published', false);
                    break;
                case 'has_quiz':
                    $query->has('quiz');
                    break;
            }
        }

        // Get counts for stats
        $totalBlogs = Blog::count();
        $featuredCount = Blog::where('is_featured', true)->count();
        $publishedCount = Blog::where('is_published', true)->count();
        $draftCount = Blog::where('is_published', false)->count();

        $blogs = $query->with('quiz')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.blogs.index', compact('blogs', 'totalBlogs', 'featuredCount', 'publishedCount', 'draftCount'));
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
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'featured_image' => 'nullable|string|max:500', // URL or path as string
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
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

        // Handle featured image - PRIORITIZE file upload over URL
        $featuredImage = null;
        
        // Check if a file was uploaded (this takes priority)
        if ($request->hasFile('featured_image_file') && $request->file('featured_image_file')->isValid()) {
            $path = $request->file('featured_image_file')->store('blogs', 'media');
            $featuredImage = Storage::disk('media')->url($path);
        } 
        // If no file, check if URL was provided
        elseif ($request->filled('featured_image')) {
            $featuredImage = $request->featured_image;
        }

        // Generate a unique slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $isPublished = $request->has('is_published') && $request->is_published == 1;
        $isFeatured = $request->has('is_featured') && $request->is_featured == 1;
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
            'is_featured' => $isFeatured,
            'published_at' => $publishedAt,
            'author' => auth()->guard('admin')->user()->name ?? 'Admin',
        ]);

        // Handle multi-question quiz
        $this->handleQuizCreation($request, $blog);

        // Log blog creation
        ActivityLogger::log('blog_created', 'Created new blog "' . $blog->title . '"', [
            'blog_id' => $blog->id,
            'title' => $blog->title,
            'category' => $blog->category,
            'is_published' => $blog->is_published,
            'is_featured' => $blog->is_featured
        ]);

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
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // File upload
            'featured_image' => 'nullable|string|max:500', // URL or path as string - FIXED
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
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

        // Handle featured image - PRIORITIZE file upload over URL
        $featuredImage = $blog->featured_image;
        
        // Check if a file was uploaded (this takes priority)
        if ($request->hasFile('featured_image_file') && $request->file('featured_image_file')->isValid()) {
            // Delete old image
            if ($blog->featured_image) {
                $oldPath = str_replace('/storage/', '', $blog->featured_image);
                if (Storage::disk('media')->exists($oldPath)) {
                    Storage::disk('media')->delete($oldPath);
                }
            }
            $path = $request->file('featured_image_file')->store('blogs', 'media');
            $featuredImage = Storage::disk('media')->url($path);
        } 
        // If no file, check if URL was provided
        elseif ($request->filled('featured_image')) {
            $featuredImage = $request->featured_image;
        }

        // Generate a unique slug (except for the current blog)
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $isPublished = $request->has('is_published') && $request->is_published == 1;
        $isFeatured = $request->has('is_featured') && $request->is_featured == 1;
        $publishedAt = $isPublished ? now() : null;

        $blog->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'category' => $validated['category'] ?? 'General',
            'tags' => $tags,
            'featured_image' => $featuredImage,
            'is_published' => $isPublished,
            'is_featured' => $isFeatured,
            'published_at' => $publishedAt,
        ]);

        // Handle quiz removal
        if ($request->has('remove_quiz') && $request->remove_quiz == 1) {
            $this->deleteQuiz($blog);
            
            ActivityLogger::log('quiz_deleted', 'Removed quiz from blog "' . $blog->title . '"', [
                'blog_id' => $blog->id
            ]);
            
            return redirect()->route('admin.blogs.edit', $blog->id)
                ->with('success', 'Blog updated successfully! Quiz removed.');
        }

        // Handle multi-question quiz
        $this->handleQuizUpdate($request, $blog);

        // Log blog update
        ActivityLogger::log('blog_updated', 'Updated blog "' . $blog->title . '"', [
            'blog_id' => $blog->id,
            'title' => $blog->title,
            'category' => $blog->category,
            'is_published' => $blog->is_published,
            'is_featured' => $blog->is_featured
        ]);

        return redirect()->route('admin.blogs.edit', $blog->id)
            ->with('success', 'Blog and quiz updated successfully!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blogTitle = $blog->title;
        
        // Delete featured image if exists
        if ($blog->featured_image) {
            $path = str_replace('/storage/', '', $blog->featured_image);
            if (Storage::disk('media')->exists($path)) {
                Storage::disk('media')->delete($path);
            }
        }
        
        // Delete associated quiz and questions
        $this->deleteQuiz($blog);
        
        $blog->delete();

        // Log blog deletion
        ActivityLogger::log('blog_deleted', 'Deleted blog "' . $blogTitle . '"', [
            'blog_id' => $id,
            'title' => $blogTitle
        ]);

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

        // Log quiz creation
        ActivityLogger::log('quiz_created', 'Created new quiz "' . $quiz->title . '" for blog "' . $blog->title . '"', [
            'quiz_id' => $quiz->id,
            'blog_id' => $blog->id,
            'title' => $quiz->title
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
            return;
        }

        // Create or update quiz
        $quiz = $blog->quiz;
        if ($quiz) {
            $oldTitle = $quiz->title;
            $quiz->update([
                'title' => $request->quiz_title,
                'description' => $request->quiz_description ?? null,
                'passing_score' => $request->quiz_passing_score ?? 60,
                'is_active' => $request->has('quiz_is_active') && $request->quiz_is_active == 1,
            ]);
            
            ActivityLogger::log('quiz_updated', 'Updated quiz "' . $oldTitle . '" to "' . $request->quiz_title . '" for blog "' . $blog->title . '"', [
                'quiz_id' => $quiz->id,
                'blog_id' => $blog->id,
                'old_title' => $oldTitle,
                'new_title' => $request->quiz_title
            ]);
        } else {
            $quiz = Quiz::create([
                'blog_id' => $blog->id,
                'title' => $request->quiz_title,
                'description' => $request->quiz_description ?? null,
                'passing_score' => $request->quiz_passing_score ?? 60,
                'is_active' => $request->has('quiz_is_active') && $request->quiz_is_active == 1,
            ]);
            
            ActivityLogger::log('quiz_created', 'Created new quiz "' . $quiz->title . '" for blog "' . $blog->title . '"', [
                'quiz_id' => $quiz->id,
                'blog_id' => $blog->id,
                'title' => $quiz->title
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
        $oldStatus = $blog->is_published;
        $blog->is_published = !$blog->is_published;
        $blog->published_at = $blog->is_published ? now() : null;
        $blog->save();

        ActivityLogger::log('blog_publish_toggled', 'Changed blog "' . $blog->title . '" publish status from ' . ($oldStatus ? 'Published' : 'Draft') . ' to ' . ($blog->is_published ? 'Published' : 'Draft'), [
            'blog_id' => $blog->id,
            'old_status' => $oldStatus ? 'Published' : 'Draft',
            'new_status' => $blog->is_published ? 'Published' : 'Draft'
        ]);

        return redirect()->back()->with('success', 
            $blog->is_published ? 'Blog published!' : 'Blog unpublished!'
        );
    }

    /**
     * Toggle blog featured status
     */
    public function toggleFeatured($id)
    {
        $blog = Blog::findOrFail($id);
        $oldStatus = $blog->is_featured;
        $blog->is_featured = !$blog->is_featured;
        $blog->save();

        // If this blog is now featured, unfeature all other blogs (optional - only 3 featured allowed)
        if ($blog->is_featured) {
            $featuredCount = Blog::where('is_featured', true)->count();
            if ($featuredCount > 3) {
                // Unfeature the oldest featured blog
                $oldestFeatured = Blog::where('is_featured', true)
                    ->orderBy('updated_at', 'asc')
                    ->first();
                if ($oldestFeatured && $oldestFeatured->id !== $blog->id) {
                    $oldestFeatured->is_featured = false;
                    $oldestFeatured->save();
                }
            }
        }

        ActivityLogger::log('blog_featured_toggled', 'Changed blog "' . $blog->title . '" featured status from ' . ($oldStatus ? 'Featured' : 'Not Featured') . ' to ' . ($blog->is_featured ? 'Featured' : 'Not Featured'), [
            'blog_id' => $blog->id,
            'old_status' => $oldStatus ? 'Featured' : 'Not Featured',
            'new_status' => $blog->is_featured ? 'Featured' : 'Not Featured'
        ]);

        return redirect()->back()->with('success', 
            $blog->is_featured ? 'Blog marked as featured!' : 'Blog removed from featured!'
        );
    }
}