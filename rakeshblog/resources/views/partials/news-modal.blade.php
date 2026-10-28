<div id="newsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeNewsDetail()"></div>
        <div class="relative bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <button type="button" onclick="closeNewsDetail()" class="sticky top-4 right-4 float-right z-10 text-gray-400 hover:text-[#D4AF37] bg-white/95 backdrop-blur-sm rounded-full p-2.5 shadow-lg transition-all duration-300 hover:scale-110 ml-4 border border-gray-100">
                <i class="fas fa-times text-lg"></i>
            </button>
            <div class="px-8 pb-8 pt-4" id="newsDetailContent">
                <div class="text-center py-12">
                    <i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i>
                    <p class="mt-3 text-[#8a8a82]">Loading story...</p>
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
        content.innerHTML = '<div class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i><p class="mt-3 text-[#8a8a82]">Loading story...</p></div>';

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
                const mainImage = item.image_url || (Array.isArray(item.images) ? item.images[0] : '');
                const date = item.published_at ? new Date(item.published_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : '';

                content.innerHTML = `
                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 border bg-amber-50 text-amber-700 border-amber-200">
                            <i class="fas fa-newspaper text-[10px]"></i>
                            ${escapeHtml(item.source_name || 'News')}
                        </span>
                        ${date ? '<span class="text-xs text-[#8a8a82]"><i class="far fa-calendar-alt"></i> ' + escapeHtml(date) + '</span>' : ''}
                    </div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#1e1e1a] mb-4 leading-tight">${escapeHtml(item.title)}</h2>
                    ${mainImage ? '<div class="mb-6 overflow-hidden rounded-2xl"><img src="' + escapeHtml(mainImage) + '" alt="' + escapeHtml(item.title) + '" class="block w-full aspect-video object-cover object-center"></div>' : ''}
                        ${item.content ? '<div class="text-[#3a3a34] leading-relaxed [&_h3]:mb-2 [&_h3]:mt-6 [&_h3]:font-serif [&_h3]:text-2xl [&_h3]:font-bold [&_p]:mb-3 [&_blockquote]:mb-3 [&_blockquote]:border-l-2 [&_blockquote]:border-[#D4AF37] [&_blockquote]:pl-4">' + item.content + '</div>' : (item.excerpt ? '<p class="text-[#3a3a34] leading-relaxed text-base mb-6">' + escapeHtml(item.excerpt) + '</p>' : '')}
                    ${item.source_url ? '<div class="mt-6 pt-4 border-t border-gray-100"><a href="' + escapeHtml(item.source_url) + '" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] hover:text-[#c4a030] transition font-medium"><i class="fas fa-external-link-alt"></i> Read at source</a></div>' : ''}
                `;
            })
            .catch(function () {
                content.innerHTML = '<div class="text-center py-12"><p class="text-[#5a5a52]">This story could not be opened.</p></div>';
            });
    }

    function closeNewsDetail() {
        document.getElementById('newsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
