@php
    $hasVideo = filled($item->video_url) || filled($item->video_file);
    $studyImage = $item->image_url ?: ($item->video_thumbnail ?? null);
    $studyDate = $item->created_at ? strtoupper($item->created_at->format('M d, Y')) : null;
    $studyText = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($item->description ?: $item->content ?: ''))));
    $studyCategory = $studyCategory ?? match ($item->category) {
        'Vision' => 'Vision',
        'Research Papers' => 'Research',
        'Media' => 'Media',
        default => $item->category,
    };
@endphp
<article class="study-card rise-item">
    <div class="study-card-media" @unless($hasVideo) onclick="openResearchDetail({{ $item->id }})" role="link" tabindex="0" onkeydown="if (event.key === 'Enter') openResearchDetail({{ $item->id }})" @endunless>
        @if(filled($studyCategory))
            <p class="study-card-category">{{ $studyCategory }}</p>
        @endif
        @if($hasVideo)
            <button type="button" class="study-play" onclick="playVideo(this, '{{ $item->id }}')" aria-label="Play {{ $item->title }}">
                <span aria-hidden="true"><i class="fas fa-play"></i></span>
            </button>
            @if($item->video_file)
                <video muted playsinline preload="metadata">
                    <source src="{{ $item->video_file }}#t=0.1" type="video/mp4">
                </video>
            @elseif($studyImage)
                <img src="{{ $studyImage }}" alt="{{ $item->title }}">
            @endif
        @elseif($studyImage)
            <img src="{{ $studyImage }}" alt="{{ $item->title }}">
        @endif
    </div>
    <div class="study-card-body">
        <div class="study-card-copy">
            @if($studyDate)
                <p class="study-card-date">{{ $studyDate }}</p>
            @endif
            <h3>{{ $item->title }}</h3>
            @if($studyText !== '')
                <p class="study-card-excerpt">{{ $studyText }}</p>
            @endif
        </div>
        <button type="button" class="study-read" onclick="openResearchDetail({{ $item->id }})">
            <span>Read more</span>
            <img src="{{ asset('images/studies/read-more-arrow.svg') }}" alt="" width="10.6667" height="10.6667">
        </button>
    </div>
</article>
