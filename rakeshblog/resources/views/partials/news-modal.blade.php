<div id="newsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeNewsDetail()"></div>
        <div class="relative research-modal-panel max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <button type="button" onclick="closeNewsDetail()" class="research-close" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div id="newsDetailContent">
                <div class="text-center py-12">
                    <i class="fas fa-spinner fa-spin text-3xl" style="color:#b36855"></i>
                    <p class="mt-3 text-[#5f5e5e]">Loading story...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openNewsDetail(id) {
        const modal = document.getElementById('newsModal');
        const content = document.getElementById('newsDetailContent');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        content.innerHTML = '<div class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl" style="color:#b36855"></i><p class="mt-3 text-[#5f5e5e]">Loading story...</p></div>';

        fetch('/news/' + id + '/detail')
            .then(function (response) {
                if (!response.ok) throw new Error('Unable to load news');
                return response.json();
            })
            .then(function (payload) {
                const item = payload.data || {};
                const escapeHtml = function (value) {
                    return String(value || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                };
                const formatStory = function (value) {
                    if (!value) return '';
                    if (!/<\/?[a-z][\s\S]*>/i.test(value)) {
                        return '<div class="research-detail-copy" style="white-space:pre-wrap">' + escapeHtml(value) + '</div>';
                    }
                    return '<div class="research-detail-copy research-rich">' + value + '</div>';
                };
                const mainImage = item.image_url || (Array.isArray(item.images) ? item.images[0] : '');
                const date = item.published_at
                    ? new Date(item.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).toUpperCase()
                    : '';
                const source = item.source_name || 'News';
                const story = item.content ? formatStory(item.content) : (item.excerpt ? '<p class="research-detail-copy">' + escapeHtml(item.excerpt) + '</p>' : '');

                content.innerHTML = `
                    <div class="research-detail">
                        <h2 class="research-detail-title">${escapeHtml(item.title)}</h2>
                        ${mainImage ? '<div class="research-detail-media"><img src="' + escapeHtml(mainImage) + '" alt="' + escapeHtml(item.title) + '"></div>' : ''}
                        <div class="research-detail-meta">
                            <span class="research-chip">${escapeHtml(source)}</span>
                            ${date ? '<span class="library-date">' + escapeHtml(date) + '</span>' : ''}
                        </div>
                        ${story ? '<div class="research-block"><h4 class="research-kicker"><span></span>Story</h4>' + story + '</div>' : ''}
                        ${item.source_url ? '<div class="research-link"><a class="library-cta" href="' + escapeHtml(item.source_url) + '" target="_blank" rel="noopener noreferrer">Read at source</a></div>' : ''}
                    </div>
                `;
            })
            .catch(function () {
                content.innerHTML = '<div class="text-center py-12"><p class="text-[#5f5e5e]">This story could not be opened.</p></div>';
            });
    }

    function closeNewsDetail() {
        document.getElementById('newsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
