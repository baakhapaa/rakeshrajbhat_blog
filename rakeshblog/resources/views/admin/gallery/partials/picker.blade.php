@php
    $existingImages = $existingImages ?? collect();
@endphp

<div id="galleryPicker">
    <div class="flex items-center justify-between gap-3 mb-3">
        <div>
            <p class="text-gray-300 text-sm font-medium">Photographs</p>
            <p class="text-xs text-gray-400 mt-1">Add images to preview them here. Remove any you do not want before saving.</p>
        </div>
        <button type="button" id="galleryAddPhotos" class="shrink-0 px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg font-semibold hover:bg-[#c4a030] transition">
            Add photographs
        </button>
    </div>

    <input type="file" id="images" name="images[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple class="sr-only" tabindex="-1">

    <div id="galleryDrop" class="rounded-xl border border-dashed border-white/15 bg-[#0b0e12] p-4">
        <div id="galleryPreview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($existingImages as $image)
                <div class="gallery-tile relative rounded-lg overflow-hidden border border-white/10 bg-black/30" data-existing="{{ $image->id }}">
                    <img src="{{ $image->url }}" alt="" class="w-full h-36 object-cover">
                    <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded bg-black/70 text-[10px] uppercase tracking-wider text-white/80">Saved</span>
                    <button type="button" class="absolute top-2 right-2 w-8 h-8 rounded-full bg-black/75 text-white hover:bg-red-600" data-remove-existing title="Remove photograph">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="hidden">
                </div>
            @endforeach
        </div>
        <p id="galleryPreviewEmpty" class="text-sm text-gray-500 text-center py-8 {{ $existingImages->isNotEmpty() ? 'hidden' : '' }}">
            No photographs yet. Use “Add photographs” or drop images here.
        </p>
    </div>
    <p class="text-xs text-gray-400 mt-2">JPG, PNG, WebP or GIF. Photographs larger than 8096 KB are compressed to under 8096 KB, then stored in the gallery folder on DigitalOcean Spaces.</p>
    @error('images')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
    @error('images.*')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('images');
                const preview = document.getElementById('galleryPreview');
                const empty = document.getElementById('galleryPreviewEmpty');
                const addButton = document.getElementById('galleryAddPhotos');
                const dropZone = document.getElementById('galleryDrop');
                const chooser = document.createElement('input');
                let pending = [];

                if (!input || !preview || !addButton) return;

                chooser.type = 'file';
                chooser.accept = input.accept;
                chooser.multiple = true;
                chooser.className = 'sr-only';
                document.getElementById('galleryPicker').appendChild(chooser);

                const updateEmpty = function () {
                    const visible = preview.querySelectorAll('.gallery-tile:not(.hidden)').length;
                    empty.classList.toggle('hidden', visible > 0);
                };

                const syncInput = function () {
                    const transfer = new DataTransfer();
                    pending.forEach(function (file) { transfer.items.add(file); });
                    input.files = transfer.files;
                };

                const renderPending = function () {
                    preview.querySelectorAll('[data-pending]').forEach(function (tile) {
                        const image = tile.querySelector('img');
                        if (image && image.dataset.objectUrl) URL.revokeObjectURL(image.dataset.objectUrl);
                        tile.remove();
                    });

                    pending.forEach(function (file, index) {
                        const tile = document.createElement('div');
                        const image = document.createElement('img');
                        const label = document.createElement('span');
                        const remove = document.createElement('button');
                        const objectUrl = URL.createObjectURL(file);

                        tile.className = 'gallery-tile relative rounded-lg overflow-hidden border border-[#D4AF37]/40 bg-black/30';
                        tile.dataset.pending = String(index);
                        image.src = objectUrl;
                        image.dataset.objectUrl = objectUrl;
                        image.alt = '';
                        image.className = 'w-full h-36 object-cover';
                        label.className = 'absolute bottom-2 left-2 right-10 px-2 py-0.5 rounded bg-black/70 text-[10px] text-white/90 truncate';
                        label.textContent = file.name;
                        remove.type = 'button';
                        remove.className = 'absolute top-2 right-2 w-8 h-8 rounded-full bg-black/75 text-white hover:bg-red-600';
                        remove.dataset.removePending = String(index);
                        remove.title = 'Remove photograph';
                        remove.innerHTML = '<i class="fas fa-times text-xs"></i>';

                        tile.append(image, label, remove);
                        preview.appendChild(tile);
                    });

                    updateEmpty();
                };

                const addFiles = function (fileList) {
                    const images = Array.from(fileList).filter(function (file) {
                        return file.type.startsWith('image/');
                    });
                    if (!images.length) return;
                    pending = pending.concat(images);
                    syncInput();
                    renderPending();
                };

                addButton.addEventListener('click', function () { chooser.click(); });
                chooser.addEventListener('change', function () {
                    addFiles(chooser.files);
                    chooser.value = '';
                });

                preview.addEventListener('click', function (event) {
                    const existingButton = event.target.closest('[data-remove-existing]');
                    if (existingButton) {
                        const tile = existingButton.closest('[data-existing]');
                        tile.classList.add('hidden');
                        tile.querySelector('input[type="checkbox"]').checked = true;
                        updateEmpty();
                        return;
                    }

                    const pendingButton = event.target.closest('[data-remove-pending]');
                    if (!pendingButton) return;
                    const index = Number(pendingButton.dataset.removePending);
                    pending.splice(index, 1);
                    syncInput();
                    renderPending();
                });

                ['dragenter', 'dragover'].forEach(function (name) {
                    dropZone.addEventListener(name, function (event) {
                        event.preventDefault();
                        dropZone.classList.add('border-[#D4AF37]');
                    });
                });
                ['dragleave', 'drop'].forEach(function (name) {
                    dropZone.addEventListener(name, function (event) {
                        event.preventDefault();
                        dropZone.classList.remove('border-[#D4AF37]');
                    });
                });
                dropZone.addEventListener('drop', function (event) {
                    addFiles(event.dataTransfer.files);
                });
            });
        </script>
    @endpush
@endonce
