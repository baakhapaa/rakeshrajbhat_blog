@extends('layouts.app')

@section('title', $blog->title . ' · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Back to Blog -->
        <a href="{{ route('blog') }}" class="inline-flex items-center text-[#D4AF37] hover:underline mb-6 group">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
            Back to Blog
        </a>

        <!-- Blog Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">{{ $blog->title }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                <span><i class="far fa-calendar-alt mr-1"></i>{{ $blog->created_at->format('F d, Y') }}</span>
                <span>•</span>
                <span class="text-[#D4AF37] font-semibold"><i class="fas fa-tag mr-1"></i>{{ $blog->category ?? 'General' }}</span>
                <span>•</span>
                <span><i class="far fa-clock mr-1"></i>{{ $blog->reading_time ?? '3 min read' }}</span>
                <span>•</span>
                <span>
                    <i class="far fa-comment mr-1"></i> {{ $blog->comments->count() }} Comments
                </span>
            </div>
        </div>

        <!-- Featured Image -->
        @if($blog->featured_image)
            <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full rounded-xl mb-8">
        @endif

        <!-- Blog Content -->
        <div class="bg-white rounded-xl p-8 shadow-md">
            <div class="blog-content prose prose-lg max-w-none">
                {!! $blog->content !!}
            </div>
        </div>

        <!-- Tags -->
        @if($blog->tags && count($blog->tags) > 0)
            <div class="flex flex-wrap gap-2 mt-8">
                @foreach($blog->tags as $tag)
                    <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-sm"><i class="fas fa-hashtag mr-1"></i>{{ $tag }}</span>
                @endforeach
            </div>
        @endif

        <!-- ========================================== -->
        <!-- QUIZ SECTION - FIXED -->
        <!-- ========================================== -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h2 class="text-2xl font-serif font-bold mb-6"><i class="fas fa-question-circle text-[#D4AF37] mr-2"></i>Quiz</h2>
            
            @php
                // Get the first active quiz with questions from DATABASE
                $activeQuiz = $blog->quizzes()->where('is_active', true)->with('questions')->first();
                
                // Check if user has completed this quiz in DATABASE
                $quizCompleted = false;
                $quizResults = null;
                
                if ($activeQuiz && Auth::check()) {
                    $existingResult = App\Models\UserQuizResult::where('user_id', Auth::id())
                        ->where('quiz_id', $activeQuiz->id)
                        ->first();
                    
                    if ($existingResult) {
                        $quizCompleted = true;
                        // Use database data, NOT session
                        $quizResults = [
                            'score' => $existingResult->score,
                            'correct' => $existingResult->correct_count,
                            'total' => $existingResult->total_questions,
                            'percentage' => $existingResult->percentage,
                            'passed' => $existingResult->passed,
                            'passing_score' => $activeQuiz->passing_score,
                            'points_earned' => $existingResult->points_earned,
                        ];
                    }
                }
                
                // ONLY use session if NOT in database (for newly completed quizzes)
                if (!$quizResults && session('quiz_results_' . ($activeQuiz->id ?? 0))) {
                    $quizResults = session('quiz_results_' . ($activeQuiz->id ?? 0));
                    $quizCompleted = session('quiz_completed_' . ($activeQuiz->id ?? 0), false);
                }
            @endphp
            
            @if($activeQuiz && $activeQuiz->questions->count() > 0)
                <!-- Quiz Dropdown Button -->
                <button onclick="toggleQuiz()" 
                        class="w-full bg-[#D4AF37] text-[#0b0e12] px-6 py-4 rounded-xl font-semibold hover:bg-[#c4a030] transition-all shadow-lg flex items-center justify-between">
                    <span class="flex items-center gap-3">
                        <i class="fas fa-puzzle-piece"></i>
                        Take Quiz: {{ $activeQuiz->title }}
                        <span class="text-sm font-normal text-[#0b0e12]/70">({{ $activeQuiz->questions->count() }} questions)</span>
                    </span>
                    <i id="quizArrow" class="fas fa-chevron-down transform transition-transform duration-300"></i>
                </button>

                <!-- Quiz Dropdown Content -->
                <div id="quizDropdown" class="hidden mt-4 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        @if($quizResults)
                            <!-- Show Results - NO RETAKE BUTTON -->
                            <div id="quizResults" class="mb-4 p-4 rounded-lg {{ $quizResults['passed'] ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-600' }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-bold text-lg">
                                            {{ $quizResults['passed'] ? '🎉 Congratulations!' : '😅 Better luck next time!' }}
                                        </p>
                                        <p class="text-sm mt-1">
                                            <i class="fas fa-check-circle mr-1"></i>You got <strong>{{ $quizResults['correct'] }}</strong> out of <strong>{{ $quizResults['total'] }}</strong> correct
                                        </p>
                                        <p class="text-xs mt-1 opacity-75">
                                            <i class="fas fa-star mr-1"></i>Score: {{ $quizResults['score'] }} points • {{ $quizResults['percentage'] }}% 
                                            (Passing: {{ $quizResults['passing_score'] }}%)
                                        </p>
                                        @if(isset($quizResults['details']))
                                            @foreach($quizResults['details'] as $detail)
                                                <p class="text-xs mt-1 {{ $detail['correct'] ? 'text-green-600' : 'text-red-600' }}">
                                                    Question {{ $loop->index + 1 }}: {{ $detail['correct'] ? '✅ Correct' : '❌ Incorrect' }}
                                                    (Your answer: {{ $detail['user_answer'] ?? 'Not answered' }} | Correct: {{ $detail['correct_answer'] }})
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="text-3xl">
                                        {{ $quizResults['passed'] ? '✅' : '❌' }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Show message that quiz is completed - NO RETAKE BUTTON -->
                            <div class="text-center py-3 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i> 
                                    You have already completed this quiz. You cannot retake it.
                                </p>
                            </div>
                            
                        @elseif($quizCompleted)
                            <div class="text-center py-4">
                                <p class="text-green-600 font-medium"><i class="fas fa-check-circle mr-2"></i>You've already completed this quiz!</p>
                                <p class="text-sm text-gray-500 mt-1"><i class="fas fa-lock mr-1"></i>You cannot retake this quiz.</p>
                            </div>
                        @else
                            <!-- Quiz Form - All questions visible -->
                            <form id="quizForm" method="POST" action="{{ route('quiz.submit', $activeQuiz->id) }}" class="space-y-6">
                                @csrf
                                <div id="answersContainer"></div>
                                
                                @foreach($activeQuiz->questions as $index => $question)
                                    <div class="bg-gray-50 rounded-lg p-4 question-item" data-question="{{ $index }}">
                                        <p class="font-medium text-gray-800 mb-3">
                                            <span class="text-[#D4AF37] font-bold">{{ $index + 1 }}.</span> {{ $question->question }}
                                            <span class="text-xs text-gray-400 ml-2">({{ $question->points }} points)</span>
                                        </p>
                                        <div class="space-y-2">
                                            @php
                                                $options = [
                                                    1 => $question->option_1,
                                                    2 => $question->option_2,
                                                    3 => $question->option_3,
                                                    4 => $question->option_4,
                                                ];
                                            @endphp
                                            @foreach($options as $optIndex => $option)
                                                <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-[#D4AF37] cursor-pointer transition-all quiz-option">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}]" 
                                                           value="{{ $optIndex - 1 }}" 
                                                           class="hidden quiz-radio">
                                                    <span class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 flex-shrink-0 option-letter">
                                                        <span class="text-xs font-bold">{{ chr(64 + $optIndex) }}</span>
                                                    </span>
                                                    <span class="text-gray-700">{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <div class="flex gap-3">
                                    <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                                        <i class="fas fa-paper-plane mr-2"></i>Submit Quiz
                                    </button>
                                    <button type="reset" class="text-gray-500 hover:text-gray-700 text-sm transition px-4 py-2">
                                        <i class="fas fa-undo mr-1"></i>Reset
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-6 text-center border border-gray-200">
                    <p class="text-gray-500"><i class="fas fa-info-circle mr-2"></i>No active quiz available for this blog.</p>
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- COMMENTS SECTION -->
        <!-- ========================================== -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h2 class="text-2xl font-serif font-bold mb-6"><i class="far fa-comments text-[#D4AF37] mr-2"></i>Comments</h2>

            <!-- Comment Form -->
            @auth
                <div class="bg-white rounded-xl p-6 shadow-md mb-8">
                    <h3 class="font-semibold text-lg mb-4"><i class="far fa-edit mr-2"></i>Leave a Comment</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                        
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Your Comment</label>
                            <textarea id="content" name="content" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"
                                placeholder="Write your comment here...">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                            <i class="fas fa-paper-plane mr-2"></i>Post Comment
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-6 text-center mb-8 border border-gray-200">
                    <p class="text-gray-600">
                        <i class="fas fa-lock mr-2"></i>
                        <a href="{{ route('login') }}" class="text-[#D4AF37] font-semibold hover:underline">Login</a> 
                        or 
                        <a href="{{ route('register') }}" class="text-[#D4AF37] font-semibold hover:underline">Register</a> 
                        to leave a comment.
                    </p>
                </div>
            @endauth

            <!-- Comments List -->
            @if($blog->comments->count() > 0)
                <div class="space-y-6">
                    @foreach($blog->comments as $comment)
                        <div class="bg-white rounded-xl p-6 shadow-md comment-item" id="comment-{{ $comment->id }}">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#D4AF37] text-[#0b0e12] flex items-center justify-center font-bold flex-shrink-0">
                                    {{ strtoupper(substr($comment->user->name ?? 'Anonymous', 0, 1)) }}
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <div>
                                            <span class="font-semibold text-gray-800"><i class="fas fa-user mr-1"></i>{{ $comment->user->name ?? 'Anonymous' }}</span>
                                            <span class="text-xs text-gray-400 ml-2"><i class="far fa-clock mr-1"></i>{{ $comment->created_at->diffForHumans() }}</span>
                                            @if($comment->created_at != $comment->updated_at)
                                                <span class="text-xs text-gray-400 ml-1">(edited)</span>
                                            @endif
                                        </div>
                                        
                                        @auth
                                            @if(Auth::id() === $comment->user_id || Auth::guard('admin')->check())
                                                <div class="flex items-center gap-2">
                                                    @if(Auth::id() === $comment->user_id)
                                                        <button onclick="openEditModal({{ $comment->id }})" 
                                                                class="text-blue-400 hover:text-blue-600 text-sm transition px-2 py-1 rounded hover:bg-blue-50">
                                                            <i class="fas fa-edit mr-1"></i>Edit
                                                        </button>
                                                    @endif
                                                    <button onclick="openDeleteModal({{ $comment->id }})" 
                                                            class="text-red-400 hover:text-red-600 text-sm transition px-2 py-1 rounded hover:bg-red-50">
                                                        <i class="fas fa-trash mr-1"></i>Delete
                                                    </button>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                    <p class="text-gray-700 mt-2 leading-relaxed comment-content" id="comment-content-{{ $comment->id }}">
                                        {{ $comment->content }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500 bg-white rounded-xl shadow-md">
                    <p><i class="far fa-comment-dots mr-2"></i>No comments yet. Be the first to share your thoughts!</p>
                </div>
            @endif
        </div>

        <!-- Related Posts -->
        @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-serif font-bold mb-6"><i class="fas fa-link text-[#D4AF37] mr-2"></i>Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedBlogs as $related)
                        <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all group">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 group-hover:text-[#D4AF37] transition-colors">
                                    <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                                </h3>
                                <p class="text-gray-600 text-sm">{!! Str::limit(strip_tags($related->content), 100) !!}</p>
                                <a href="{{ route('blog.show', $related->slug) }}" class="inline-block mt-2 text-sm text-[#D4AF37] hover:underline">
                                    Read More <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- ========================================== -->
<!-- EDIT COMMENT MODAL -->
<!-- ========================================== -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-2xl p-8 max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-serif font-bold text-gray-800"><i class="fas fa-edit mr-2"></i>Edit Comment</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
        </div>
        
        <form id="editCommentForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_content" class="block text-sm font-medium text-gray-700 mb-2">Your Comment</label>
                <textarea id="edit_content" name="content" rows="4" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all flex-1">
                    <i class="fas fa-save mr-2"></i>Update Comment
                </button>
                <button type="button" onclick="closeEditModal()" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash text-2xl text-red-500"></i>
            </div>
            <h3 class="text-2xl font-serif font-bold text-gray-800 mb-2">Delete Comment?</h3>
            <p class="text-gray-500 mb-6">Are you sure you want to delete this comment? This action cannot be undone.</p>
            <div class="flex gap-3">
                <form id="deleteCommentForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600 transition-all">
                        <i class="fas fa-trash mr-2"></i>Yes, Delete
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="flex-1 border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // ==========================================
    // QUIZ DROPDOWN TOGGLE
    // ==========================================
    function toggleQuiz() {
        const dropdown = document.getElementById('quizDropdown');
        const arrow = document.getElementById('quizArrow');
        
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            arrow.style.transform = 'rotate(180deg)';
        } else {
            dropdown.classList.add('hidden');
            arrow.style.transform = 'rotate(0deg)';
        }
    }

    // ==========================================
    // QUIZ OPTION SELECTION
    // ==========================================
    document.querySelectorAll('.quiz-option').forEach(label => {
        label.addEventListener('click', function(e) {
            if (e.target.tagName === 'INPUT') return;
            
            const radio = this.querySelector('.quiz-radio');
            const parent = this.closest('.question-item');
            
            parent.querySelectorAll('.quiz-option').forEach(opt => {
                opt.classList.remove('border-[#D4AF37]', 'bg-[#D4AF37]/10');
                opt.querySelector('.option-letter span').style.color = '';
                opt.querySelector('.option-letter').style.borderColor = '';
            });
            
            this.classList.add('border-[#D4AF37]', 'bg-[#D4AF37]/10');
            this.querySelector('.option-letter span').style.color = '#D4AF37';
            this.querySelector('.option-letter').style.borderColor = '#D4AF37';
            radio.checked = true;
        });
    });

    // ==========================================
    // COMMENT EDIT/DELETE MODALS
    // ==========================================

    function openEditModal(commentId) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editCommentForm');
        const content = document.getElementById('comment-content-' + commentId);
        const textarea = document.getElementById('edit_content');
        
        form.action = '/comments/' + commentId;
        textarea.value = content.textContent.trim();
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function openDeleteModal(commentId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteCommentForm');
        
        form.action = '/comments/' + commentId;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
            closeDeleteModal();
        }
    });

    // Close modals when clicking outside
    document.querySelectorAll('#editModal .absolute:first-child, #deleteModal .absolute:first-child').forEach(el => {
        el.addEventListener('click', function() {
            closeEditModal();
            closeDeleteModal();
        });
    });

    // ==========================================
    // RESET QUIZ - REMOVED (No retake allowed)
    // ==========================================
    // Reset functionality has been removed. Users cannot retake quizzes.
</script>

<!-- Styles -->
<style>
    .blog-content {
        font-family: 'Inter', sans-serif;
        line-height: 1.8;
        color: #1e1e1a;
    }
    
    .blog-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .blog-content h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-top: 1.8rem;
        margin-bottom: 0.8rem;
        font-family: 'Playfair Display', serif;
    }
    
    .blog-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.6rem;
        font-family: 'Playfair Display', serif;
    }
    
    .blog-content h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .blog-content p {
        margin-bottom: 1rem;
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .blog-content ul, .blog-content ol {
        margin: 1rem 0 1rem 2rem;
    }
    
    .blog-content ul {
        list-style-type: disc;
    }
    
    .blog-content ol {
        list-style-type: decimal;
    }
    
    .blog-content li {
        margin-bottom: 0.5rem;
        font-size: 1.05rem;
    }
    
    .blog-content a {
        color: #D4AF37;
        text-decoration: underline;
    }
    
    .blog-content a:hover {
        color: #b8922a;
    }
    
    .blog-content blockquote {
        border-left: 4px solid #D4AF37;
        padding: 0.5rem 1.5rem;
        margin: 1.5rem 0;
        background: #f8f6f0;
        border-radius: 0 8px 8px 0;
        font-style: italic;
        font-size: 1.1rem;
    }
    
    .blog-content blockquote p {
        margin-bottom: 0;
    }
    
    .blog-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
    }
    
    .blog-content table th {
        background: #f2f2f2;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        border: 1px solid #ddd;
    }
    
    .blog-content table td {
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
    }
    
    .blog-content table tr:nth-child(even) {
        background: #f9f9f9;
    }
    
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    
    .blog-content code {
        background: #f4f4f4;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.9rem;
    }
    
    .blog-content pre {
        background: #1e1e1a;
        color: #f0efe7;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1.5rem 0;
    }
    
    .blog-content pre code {
        background: transparent;
        color: inherit;
        padding: 0;
    }
    
    .quiz-option:hover {
        border-color: #D4AF37 !important;
        background: rgba(212, 175, 55, 0.05) !important;
    }
    
    .quiz-option {
        transition: all 0.2s ease;
    }
    
    .comment-item {
        transition: all 0.2s ease;
    }
    
    .comment-item:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }
    
    /* Modal animations */
    #editModal, #deleteModal {
        transition: all 0.3s ease;
    }
    
    #editModal .absolute:last-child, #deleteModal .absolute:last-child {
        animation: modalSlideIn 0.3s ease;
    }
    
    @keyframes modalSlideIn {
        from {
            transform: translate(-50%, -50%) scale(0.9);
            opacity: 0;
        }
        to {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }
    
    @media (max-width: 768px) {
        .blog-content h1 {
            font-size: 2rem;
        }
        .blog-content h2 {
            font-size: 1.6rem;
        }
        .blog-content h3 {
            font-size: 1.3rem;
        }
        .blog-content p {
            font-size: 1rem;
        }
        .blog-content table {
            font-size: 0.9rem;
        }
        .blog-content table th,
        .blog-content table td {
            padding: 0.5rem;
        }
    }
</style>
@endsection