@extends('admin.layouts.app')

@section('title', 'Legal pages · Admin')

@section('content')
@php
    $legalTab = 'privacy';
    foreach ($errors->keys() as $field) {
        if (str_starts_with($field, 'terms_')) {
            $legalTab = 'terms';
            break;
        }
        if (str_starts_with($field, 'privacy_')) {
            $legalTab = 'privacy';
            break;
        }
    }
    $legalPages = [
        'privacy' => ['heading' => 'Privacy policy', 'page' => $privacy],
        'terms' => ['heading' => 'Terms & conditions', 'page' => $terms],
    ];
@endphp
<div>
    <div class="max-w-5xl mx-auto mb-6">
        <h1 class="text-3xl font-serif font-bold text-white">Legal pages</h1>
        <p class="text-white/50 text-sm mt-2">Update the privacy policy and terms. Use the editor for headings, bold, lists and links.</p>
    </div>

    @if(session('success'))
        <div class="max-w-5xl mx-auto bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-5xl mx-auto bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-5xl mx-auto flex flex-wrap gap-2 mb-6 border-b border-white/10">
        @foreach($legalPages as $key => $section)
            <button type="button" onclick="switchLegalTab('{{ $key }}')" id="tab-{{ $key }}"
                class="legal-tab px-4 py-2 text-sm font-medium transition border-b-2 hover:text-white {{ $legalTab === $key ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 border-transparent' }}">
                {{ $section['heading'] }}
            </button>
        @endforeach
    </div>

    <form action="{{ route('admin.legal.update') }}" method="POST">
        @csrf
        @method('PUT')

        @foreach($legalPages as $key => $section)
            @php($page = $section['page'])
            <section data-legal-panel="{{ $key }}" class="{{ $legalTab === $key ? '' : 'hidden' }}">
                <div class="max-w-5xl mx-auto grid gap-4 md:grid-cols-2 mb-4">
                    <div>
                        <label for="{{ $key }}_title" class="block text-white/70 text-sm font-medium mb-2">Title</label>
                        <input type="text" id="{{ $key }}_title" name="{{ $key }}_title" value="{{ old($key.'_title', $page['title']) }}" maxlength="160"
                            class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    </div>
                    <div>
                        <label for="{{ $key }}_updated_on" class="block text-white/70 text-sm font-medium mb-2">Last updated</label>
                        <input type="date" id="{{ $key }}_updated_on" name="{{ $key }}_updated_on" value="{{ old($key.'_updated_on', $page['updated_on']) }}"
                            class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    </div>
                </div>

                <div class="max-w-5xl mx-auto mb-4">
                    <label for="{{ $key }}_meta_description" class="block text-white/70 text-sm font-medium mb-2">Short description</label>
                    <input type="text" id="{{ $key }}_meta_description" name="{{ $key }}_meta_description" value="{{ old($key.'_meta_description', $page['meta_description']) }}" maxlength="300"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                </div>

                <div class="max-w-5xl mx-auto">
                    <x-ckeditor :id="$key.'_body'" :name="$key.'_body'" :value="old($key.'_body', $page['body'])" height="640" />
                </div>
            </section>
        @endforeach

        <div class="max-w-5xl mx-auto mt-4">
            <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                Save legal pages
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function switchLegalTab(tab) {
        document.querySelectorAll('[data-legal-panel]').forEach(function (panel) {
            const active = panel.dataset.legalPanel === tab;
            panel.classList.toggle('hidden', !active);
        });
        document.querySelectorAll('.legal-tab').forEach(function (button) {
            const active = button.id === 'tab-' + tab;
            button.classList.toggle('text-[#D4AF37]', active);
            button.classList.toggle('border-[#D4AF37]', active);
            button.classList.toggle('text-white/60', !active);
            button.classList.toggle('border-transparent', !active);
        });
        requestAnimationFrame(function () {
            const editor = window.tinymce && tinymce.get(tab + '_body');
            const container = editor && editor.getContainer();
            if (container) container.style.width = '100%';
        });
    }
</script>
@endpush
