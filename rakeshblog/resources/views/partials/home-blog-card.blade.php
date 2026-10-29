@php
    $studyImage = $blog->featured_image_url;
    $studyDate = $blog->published_at ? strtoupper($blog->published_at->format('M d, Y')) : ($blog->created_at ? strtoupper($blog->created_at->format('M d, Y')) : null);
    $studyText = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($blog->excerpt ?: $blog->content ?: ''))));
    $studyUrl = route('blog.show', $blog->slug);
@endphp
<article class="study-card rise-item">
    <a class="study-card-media" href="{{ $studyUrl }}">
        <p class="study-card-category">{{ $studyCategory ?? 'Blog' }}</p>
        @if($studyImage)
            <img src="{{ $studyImage }}" alt="{{ $blog->title }}">
        @endif
    </a>
    <div class="study-card-body">
        <div class="study-card-copy">
            @if($studyDate)
                <p class="study-card-date">{{ $studyDate }}</p>
            @endif
            <h3><a href="{{ $studyUrl }}">{{ $blog->title }}</a></h3>
            @if($studyText !== '')
                <p class="study-card-excerpt">{{ $studyText }}</p>
            @endif
        </div>
        <a class="study-read" href="{{ $studyUrl }}">
            <span>Read more</span>
            <img src="{{ asset('images/studies/read-more-arrow.svg') }}" alt="" width="10.6667" height="10.6667">
        </a>
    </div>
</article>
