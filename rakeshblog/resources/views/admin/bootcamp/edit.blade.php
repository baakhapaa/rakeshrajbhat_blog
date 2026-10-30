@extends('admin.layouts.app')

@section('title', 'Bootcamp · Admin')

@section('content')
@php
    $audienceRows = old('audiences');
    if (! is_array($audienceRows)) {
        $audienceRows = array_map(fn ($label) => ['label' => $label], $page['audiences']);
    }
    $stepRows = old('steps', $page['steps']);
    $offeringRows = old('offerings', $page['offerings']);
    if (! is_array($stepRows) || $stepRows === []) {
        $stepRows = [['title' => '', 'body' => '']];
    }
    if (! is_array($offeringRows) || $offeringRows === []) {
        $offeringRows = [['icon' => 'fa-star', 'kicker' => '', 'title' => '']];
    }
    if ($audienceRows === []) {
        $audienceRows = [['label' => '']];
    }
@endphp
<div class="max-w-5xl mx-auto">
    <div class="flex flex-wrap items-start justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
                <i class="fas fa-chalkboard-user text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-serif font-bold text-white">Book a Bootcamp</h1>
                <p class="text-gray-400 text-sm mt-0.5">Update the page heading, the right side, and the “Who is this for?” choices on the form.</p>
            </div>
        </div>
        <a href="{{ route('admin.bootcamp.requests') }}" class="px-4 py-2 text-sm text-white/80 border border-white/10 rounded-lg hover:text-white">View requests</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-5 py-4 rounded-2xl mb-6">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-5 py-4 rounded-2xl mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bootcamp.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="bg-[#1a1f26] rounded-2xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-1">Page heading</h2>
            <p class="text-sm text-gray-400 mb-5">This is the title and paragraph at the top of the bootcamp page.</p>
            <div class="space-y-4">
                <div>
                    <label for="hero_kicker" class="block text-sm text-white/70 mb-2">Label</label>
                    <input id="hero_kicker" type="text" name="hero_kicker" value="{{ old('hero_kicker', $page['hero_kicker']) }}" maxlength="40" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
                <div>
                    <label for="hero_heading" class="block text-sm text-white/70 mb-2">Heading</label>
                    <input id="hero_heading" type="text" name="hero_heading" value="{{ old('hero_heading', $page['hero_heading']) }}" maxlength="160" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
                <div>
                    <label for="hero_intro" class="block text-sm text-white/70 mb-2">Paragraph</label>
                    <textarea id="hero_intro" name="hero_intro" rows="3" maxlength="400" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">{{ old('hero_intro', $page['hero_intro']) }}</textarea>
                </div>
            </div>
        </section>

        <section class="bg-[#1a1f26] rounded-2xl border border-white/5 p-6">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-xl font-semibold text-white">Who is this for?</h2>
                    <p class="text-sm text-gray-400 mt-1">These are the choices on the request form. Remove a row to take it off the page.</p>
                </div>
                <button type="button" id="addAudience" class="px-3 py-2 text-sm text-[#0b0e12] bg-[#D4AF37] rounded-lg font-semibold hover:bg-[#c4a030]">Add choice</button>
            </div>
            <div id="audienceRows" class="space-y-3">
                @foreach($audienceRows as $row)
                    <div class="audience-row flex items-center gap-2">
                        <input type="text" name="audiences[][label]" value="{{ $row['label'] ?? '' }}" maxlength="60" placeholder="Students" class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <button type="button" class="move-up px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move up">↑</button>
                        <button type="button" class="move-down px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move down">↓</button>
                        <button type="button" class="remove-row px-3 py-2 text-sm text-red-300 border border-red-500/20 rounded-lg hover:text-red-200">Remove</button>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-[#1a1f26] rounded-2xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-1">How it works</h2>
            <p class="text-sm text-gray-400 mb-5">This is the first block on the right side of the bootcamp page.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="process_label" class="block text-sm text-white/70 mb-2">Label</label>
                    <input id="process_label" type="text" name="process_label" value="{{ old('process_label', $page['process_label']) }}" maxlength="80" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
                <div>
                    <label for="process_heading" class="block text-sm text-white/70 mb-2">Heading</label>
                    <input id="process_heading" type="text" name="process_heading" value="{{ old('process_heading', $page['process_heading']) }}" maxlength="120" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
            </div>
            <div class="flex items-center justify-between gap-3 mb-3">
                <p class="text-sm text-white/60">Steps</p>
                <button type="button" id="addStep" class="px-3 py-2 text-sm text-white/80 border border-white/10 rounded-lg hover:text-white">Add step</button>
            </div>
            <div id="stepRows" class="space-y-3">
                @foreach($stepRows as $row)
                    <div class="step-row grid grid-cols-1 md:grid-cols-[1fr_1.4fr_auto] gap-2 items-start">
                        <input type="text" data-field="title" name="steps[{{ $loop->index }}][title]" value="{{ $row['title'] ?? '' }}" maxlength="80" placeholder="Step title" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <input type="text" data-field="body" name="steps[{{ $loop->index }}][body]" value="{{ $row['body'] ?? '' }}" maxlength="200" placeholder="Short description" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <div class="flex gap-2">
                            <button type="button" class="move-up px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move up">↑</button>
                            <button type="button" class="move-down px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move down">↓</button>
                            <button type="button" class="remove-row px-3 py-2 text-sm text-red-300 border border-red-500/20 rounded-lg hover:text-red-200">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-[#1a1f26] rounded-2xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-1">What we can deliver</h2>
            <p class="text-sm text-gray-400 mb-5">This is the second block on the right side of the bootcamp page.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="expertise_label" class="block text-sm text-white/70 mb-2">Label</label>
                    <input id="expertise_label" type="text" name="expertise_label" value="{{ old('expertise_label', $page['expertise_label']) }}" maxlength="80" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
                <div>
                    <label for="expertise_heading" class="block text-sm text-white/70 mb-2">Heading</label>
                    <input id="expertise_heading" type="text" name="expertise_heading" value="{{ old('expertise_heading', $page['expertise_heading']) }}" maxlength="120" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
            </div>
            <div class="flex items-center justify-between gap-3 mb-3">
                <p class="text-sm text-white/60">Topics</p>
                <button type="button" id="addOffering" class="px-3 py-2 text-sm text-white/80 border border-white/10 rounded-lg hover:text-white">Add topic</button>
            </div>
            <div id="offeringRows" class="space-y-3">
                @foreach($offeringRows as $row)
                    <div class="offering-row grid grid-cols-1 md:grid-cols-[auto_1fr_1fr_auto] gap-2 items-start">
                        <select data-field="icon" name="offerings[{{ $loop->index }}][icon]" class="px-3 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                            @foreach($icons as $icon => $name)
                                <option value="{{ $icon }}" @selected(($row['icon'] ?? 'fa-star') === $icon)>{{ $name }}</option>
                            @endforeach
                        </select>
                        <input type="text" data-field="kicker" name="offerings[{{ $loop->index }}][kicker]" value="{{ $row['kicker'] ?? '' }}" maxlength="40" placeholder="Label" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <input type="text" data-field="title" name="offerings[{{ $loop->index }}][title]" value="{{ $row['title'] ?? '' }}" maxlength="40" placeholder="Title" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <div class="flex gap-2">
                            <button type="button" class="move-up px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move up">↑</button>
                            <button type="button" class="move-down px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move down">↓</button>
                            <button type="button" class="remove-row px-3 py-2 text-sm text-red-300 border border-red-500/20 rounded-lg hover:text-red-200">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-3 rounded-xl font-semibold hover:bg-[#c4a030] transition">Save bootcamp page</button>
    </form>
</div>

<template id="audienceTemplate">
    <div class="audience-row flex items-center gap-2">
        <input type="text" name="audiences[][label]" value="" maxlength="60" placeholder="Students" class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <button type="button" class="move-up px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move up">↑</button>
        <button type="button" class="move-down px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move down">↓</button>
        <button type="button" class="remove-row px-3 py-2 text-sm text-red-300 border border-red-500/20 rounded-lg hover:text-red-200">Remove</button>
    </div>
</template>
<template id="stepTemplate">
    <div class="step-row grid grid-cols-1 md:grid-cols-[1fr_1.4fr_auto] gap-2 items-start">
        <input type="text" data-field="title" name="steps[0][title]" value="" maxlength="80" placeholder="Step title" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <input type="text" data-field="body" name="steps[0][body]" value="" maxlength="200" placeholder="Short description" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <div class="flex gap-2">
            <button type="button" class="move-up px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move up">↑</button>
            <button type="button" class="move-down px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move down">↓</button>
            <button type="button" class="remove-row px-3 py-2 text-sm text-red-300 border border-red-500/20 rounded-lg hover:text-red-200">Remove</button>
        </div>
    </div>
</template>
<template id="offeringTemplate">
    <div class="offering-row grid grid-cols-1 md:grid-cols-[auto_1fr_1fr_auto] gap-2 items-start">
        <select data-field="icon" name="offerings[0][icon]" class="px-3 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
            @foreach($icons as $icon => $name)
                <option value="{{ $icon }}">{{ $name }}</option>
            @endforeach
        </select>
        <input type="text" data-field="kicker" name="offerings[0][kicker]" value="" maxlength="40" placeholder="Label" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <input type="text" data-field="title" name="offerings[0][title]" value="" maxlength="40" placeholder="Title" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <div class="flex gap-2">
            <button type="button" class="move-up px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move up">↑</button>
            <button type="button" class="move-down px-3 py-2 text-sm text-white/70 border border-white/10 rounded-lg hover:text-white" aria-label="Move down">↓</button>
            <button type="button" class="remove-row px-3 py-2 text-sm text-red-300 border border-red-500/20 rounded-lg hover:text-red-200">Remove</button>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    function bindBootcampList(list, template, addButton, rowClass, limit) {
        function bindRow(row) {
            row.querySelector('.remove-row').addEventListener('click', function () {
                row.remove();
            });
            row.querySelector('.move-up').addEventListener('click', function () {
                const previous = row.previousElementSibling;
                if (previous) list.insertBefore(row, previous);
            });
            row.querySelector('.move-down').addEventListener('click', function () {
                const next = row.nextElementSibling;
                if (next) list.insertBefore(next, row);
            });
        }

        list.querySelectorAll('.' + rowClass).forEach(bindRow);
        addButton.addEventListener('click', function () {
            if (list.querySelectorAll('.' + rowClass).length >= limit) return;
            const row = template.content.firstElementChild.cloneNode(true);
            list.appendChild(row);
            bindRow(row);
        });
    }

    bindBootcampList(document.getElementById('audienceRows'), document.getElementById('audienceTemplate'), document.getElementById('addAudience'), 'audience-row', 12);
    bindBootcampList(document.getElementById('stepRows'), document.getElementById('stepTemplate'), document.getElementById('addStep'), 'step-row', 8);
    bindBootcampList(document.getElementById('offeringRows'), document.getElementById('offeringTemplate'), document.getElementById('addOffering'), 'offering-row', 8);

    document.querySelector('form[action*="bootcamp"]').addEventListener('submit', function () {
        document.querySelectorAll('#stepRows .step-row').forEach(function (row, index) {
            row.querySelectorAll('[data-field]').forEach(function (field) {
                field.name = 'steps[' + index + '][' + field.dataset.field + ']';
            });
        });
        document.querySelectorAll('#offeringRows .offering-row').forEach(function (row, index) {
            row.querySelectorAll('[data-field]').forEach(function (field) {
                field.name = 'offerings[' + index + '][' + field.dataset.field + ']';
            });
        });
    });
</script>
@endpush
