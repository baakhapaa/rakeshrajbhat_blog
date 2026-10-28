@props(['id' => 'content', 'name' => 'content', 'value' => '', 'height' => 500])

<textarea id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition']) }}
    rows="15"
>{{ $value }}</textarea>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof initCKEditor === 'function') {
            initCKEditor('#{{ $id }}', { height: @json(is_numeric($height) ? (int) $height : (string) $height) });
        }
    });
</script>
@endpush
