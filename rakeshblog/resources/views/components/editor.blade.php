<textarea id="{{ $id ?? 'editor' }}" name="{{ $name ?? 'content' }}" 
    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition"
    rows="{{ $rows ?? 10 }}"
    placeholder="{{ $placeholder ?? 'Write your content here...' }}"
>{{ $value ?? old($name ?? 'content') }}</textarea>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#{{ $id ?? 'editor' }}',
            height: {{ $height ?? 500 }},
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | ' +
                'link image media | ' +
                'table | removeformat | help',
            content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px; color:#1e1e1a; }',
            content_css: 'default',
            branding: false,
            promotion: false,
            skin: 'oxide-dark',
            skin_mode: 'dark',
            @if(request()->routeIs('admin.*'))
            // Admin specific settings
            skin: 'oxide-dark',
            skin_mode: 'dark',
            @endif
        });
    });
</script>
@endpush