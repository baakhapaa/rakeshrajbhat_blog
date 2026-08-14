@props(['id' => 'content', 'name' => 'content', 'value' => '', 'height' => 500])

<textarea id="{{ $id }}" name="{{ $name }}" 
    {{ $attributes->merge(['class' => 'w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition']) }}
    rows="15"
>{{ $value }}</textarea>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Decode HTML entities for CKEditor
        const textarea = document.querySelector('#{{ $id }}');
        if (textarea) {
            const decodedValue = textarea.value;
            // If the value contains HTML entities, decode them
            if (decodedValue.includes('&lt;') || decodedValue.includes('&gt;') || decodedValue.includes('&amp;')) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = decodedValue;
                textarea.value = tempDiv.textContent || tempDiv.innerText || decodedValue;
            }
        }

        if (typeof initCKEditor === 'function') {
            initCKEditor('#{{ $id }}', { height: {{ $height }} });
        } else {
            const element = document.querySelector('#{{ $id }}');
            if (element && typeof ClassicEditor !== 'undefined') {
                ClassicEditor
                    .create(element, {
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'underline', 'strikethrough', '|',
                                'alignment', '|',
                                'bulletedList', 'numberedList', '|',
                                'link', 'imageUpload', '|',
                                'blockQuote', 'insertTable', 'mediaEmbed', '|',
                                'undo', 'redo'
                            ]
                        },
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                            ]
                        },
                        language: 'en',
                        height: {{ $height }},
                        removePlugins: ['Title']
                    })
                    .catch(error => {
                        console.error('CKEditor Error:', error);
                    });
            }
        }
    });
</script>
@endpush