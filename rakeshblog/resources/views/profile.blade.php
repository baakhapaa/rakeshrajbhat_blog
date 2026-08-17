@extends('layouts.app')

@section('title', 'Profile · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-[#D4AF37] to-[#c4a030] px-8 py-12">
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white">
                        <span class="text-4xl font-bold text-white">
                            {{ Auth::user()->initials ?? strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-serif font-bold text-white">{{ Auth::user()->name }}</h1>
                        <p class="text-white/80"><i class="fas fa-envelope mr-2"></i>{{ Auth::user()->email }}</p>
                        <p class="text-white/70 text-sm mt-1"><i class="fas fa-calendar-alt mr-2"></i>Member since {{ Auth::user()->created_at->format('F Y') }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-white text-xs font-semibold">
                                <i class="fas fa-star mr-1"></i> {{ Auth::user()->level_icon ?? '🌱' }} {{ Auth::user()->level ?? 'Beginner' }}
                            </span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-white text-xs font-semibold">
                                <i class="fas fa-trophy mr-1"></i> Rank #{{ Auth::user()->rank ?? 1 }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="p-8">
                <!-- ========================================== -->
                <!-- POINTS SECTION - MAIN FOCUS -->
                <!-- ========================================== -->
                <div class="mb-8 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl p-6 border border-yellow-200">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-coins text-[#D4AF37] mr-2"></i>Total Points Earned
                            </h3>
                            <p class="text-5xl font-bold text-[#D4AF37]">{{ number_format(Auth::user()->total_points ?? 0) }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-level-up-alt text-[#D4AF37] mr-1"></i> Level: <span class="font-semibold text-[#D4AF37]">{{ Auth::user()->level ?? 'Beginner' }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500"><i class="fas fa-trophy text-[#D4AF37] mr-1"></i>Rank: <span class="font-semibold">#{{ Auth::user()->rank ?? 1 }}</span></p>
                            @if(($nextLevel = Auth::user()->next_level_points ?? 0) > 0)
                                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-arrow-up mr-1"></i>{{ $nextLevel }} points to next level</p>
                            @else
                                <p class="text-xs text-green-600 mt-1"><i class="fas fa-crown mr-1"></i>Maximum level reached!</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    @if(($nextLevel = Auth::user()->next_level_points ?? 0) > 0)
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-[#D4AF37] to-[#c4a030] h-3 rounded-full transition-all duration-500" 
                                     style="width: {{ min(Auth::user()->progress ?? 0, 100) }}%">
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-chart-line mr-1"></i>{{ round(Auth::user()->progress ?? 0, 1) }}% to next level</p>
                        </div>
                    @endif
                </div>

                <!-- ========================================== -->
                <!-- QUIZ STATS GRID -->
                <!-- ========================================== -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-100 hover:shadow-md transition-all">
                        <i class="fas fa-question-circle text-2xl text-blue-500 mb-1"></i>
                        <p class="text-2xl font-bold text-blue-600">{{ Auth::user()->quiz_attempts ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">Quizzes Taken</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 text-center border border-green-100 hover:shadow-md transition-all">
                        <i class="fas fa-check-circle text-2xl text-green-500 mb-1"></i>
                        <p class="text-2xl font-bold text-green-600">{{ Auth::user()->correct_answers ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">Correct Answers</p>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 text-center border border-purple-100 hover:shadow-md transition-all">
                        <i class="fas fa-list-ul text-2xl text-purple-500 mb-1"></i>
                        <p class="text-2xl font-bold text-purple-600">{{ Auth::user()->total_questions_answered ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">Questions Answered</p>
                    </div>
                    <div class="bg-amber-50 rounded-xl p-4 text-center border border-amber-100 hover:shadow-md transition-all">
                        <i class="fas fa-bullseye text-2xl text-amber-500 mb-1"></i>
                        <p class="text-2xl font-bold text-amber-600">
                            {{ Auth::user()->accuracy ?? 0 }}%
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Accuracy</p>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- RECENT QUIZ RESULTS WITH POINTS EARNED -->
                <!-- ========================================== -->
                @php
                    $recentResults = App\Models\UserQuizResult::where('user_id', Auth::id())
                        ->with('quiz')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentResults->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold mb-4"><i class="fas fa-history text-[#D4AF37] mr-2"></i>Recent Quiz Results</h3>
                        <div class="space-y-3">
                            @foreach($recentResults as $result)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 flex items-center justify-between flex-wrap gap-3 hover:shadow-md transition-all">
                                    <div>
                                        <p class="font-medium text-gray-800"><i class="fas fa-file-alt text-[#D4AF37] mr-2"></i>{{ $result->quiz->title ?? 'Quiz' }}</p>
                                        <p class="text-sm text-gray-500"><i class="far fa-clock mr-1"></i>{{ $result->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center gap-4 flex-wrap">
                                        <div class="text-center">
                                            <p class="text-sm font-semibold text-gray-600">{{ $result->percentage }}%</p>
                                            <p class="text-xs text-gray-400">Score</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm font-semibold text-gray-600">{{ $result->correct_count }}/{{ $result->total_questions }}</p>
                                            <p class="text-xs text-gray-400">Correct</p>
                                        </div>
                                        <div class="text-center">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $result->passed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                @if($result->passed)
                                                    <i class="fas fa-check-circle mr-1"></i> Passed
                                                @else
                                                    <i class="fas fa-times-circle mr-1"></i> Failed
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-center bg-[#D4AF37]/10 rounded-lg px-3 py-1">
                                            <p class="text-sm font-bold text-[#D4AF37]"><i class="fas fa-plus-circle mr-1"></i>{{ $result->points_earned }}</p>
                                            <p class="text-xs text-gray-400">Points Earned</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- ========================================== -->
                <!-- PROFILE INFORMATION -->
                <!-- ========================================== -->
                <h2 class="text-xl font-bold mb-6"><i class="fas fa-user-circle text-[#D4AF37] mr-2"></i>Profile Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-all">
                        <label class="text-xs text-gray-500 uppercase font-semibold"><i class="fas fa-user mr-1"></i>Full Name</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-all">
                        <label class="text-xs text-gray-500 uppercase font-semibold"><i class="fas fa-envelope mr-1"></i>Email Address</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->email }}</p>
                    </div>
                    
                    @if(Auth::user()->phone)
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-all">
                        <label class="text-xs text-gray-500 uppercase font-semibold"><i class="fas fa-phone mr-1"></i>Phone Number</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->phone }}</p>
                    </div>
                    @endif
                    
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-all">
                        <label class="text-xs text-gray-500 uppercase font-semibold"><i class="fas fa-calendar-plus mr-1"></i>Account Created</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-all">
                        <label class="text-xs text-gray-500 uppercase font-semibold"><i class="fas fa-edit mr-1"></i>Last Updated</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->updated_at->format('M d, Y') }}</p>
                    </div>
                    
                    @if(Auth::user()->last_login_at)
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-all">
                        <label class="text-xs text-gray-500 uppercase font-semibold"><i class="fas fa-sign-in-alt mr-1"></i>Last Login</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->last_login_at->diffForHumans() }}</p>
                    </div>
                    @endif
                    
                    @if(Auth::user()->ip_address)
                    {{-- <div class="bg-gray-50 rounded-lg p-4 md:col-span-2 hover:shadow-md transition-all">
                        <label class="text-xs text-gray-500 uppercase font-semibold"><i class="fas fa-network-wired mr-1"></i>IP Address</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->ip_address }}</p>
                    </div> --}}
                    @endif
                </div>

                <!-- ========================================== -->
                <!-- ACTION BUTTON -->
                <!-- ========================================== -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('settings') }}" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2.5 rounded-lg font-semibold hover:bg-[#c4a030] transition-all inline-flex items-center gap-2">
                        <i class="fas fa-cog"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .group:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    /* Hover effects for stat cards */
    .bg-blue-50:hover,
    .bg-green-50:hover,
    .bg-purple-50:hover,
    .bg-amber-50:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }
    
    /* Icon colors */
    .fa-coins {
        color: #D4AF37;
    }
    
    .fa-trophy {
        color: #D4AF37;
    }
</style>
@endsection