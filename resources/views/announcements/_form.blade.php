<div class="space-y-6">
    <div>
        <x-input-label for="title" :value="__('Announcement Title')" />

        <x-text-input
            id="title"
            name="title"
            type="text"
            class="mt-1 block w-full"
            :value="old('title', $announcement->title ?? '')"
            required
        />

        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="content" :value="__('Content')" />

        <textarea
            id="content"
            name="content"
            rows="8"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
            required
        >{{ old('content', $announcement->content ?? '') }}</textarea>

        <x-input-error :messages="$errors->get('content')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div>
            <x-input-label for="status" :value="__('Status')" />

            <select
                id="status"
                name="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                required
            >
                <option value="draft" @selected(old('status', $announcement->status ?? 'draft') === 'draft')>
                    Draft
                </option>

                <option value="published" @selected(old('status', $announcement->status ?? '') === 'published')>
                    Published
                </option>
            </select>

            <p class="mt-1 text-xs text-gray-500">
                Draft announcements are not visible to alumni. Published announcements are visible to alumni.
            </p>

            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Announcement Image')" />

            <input
                id="image"
                name="image"
                type="file"
                accept="image/png,image/jpeg,image/jpg,image/webp"
                class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-[#6B0F1A] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#4A0A12]"
            />

            <p class="mt-1 text-xs text-gray-500">
               Accepted formats: JPG, JPEG, PNG, WEBP. Max size: 2MB.
            </p>

            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>
    </div>

    @if (isset($announcement) && $announcement->image)
        <div>
            <p class="mb-2 text-sm font-medium text-gray-700">
                Current Announcement Image
            </p>

            <img
                src="{{ asset('storage/' . $announcement->image) }}"
                alt="{{ $announcement->title }}"
                class="h-56 w-full rounded-xl border border-gray-200 bg-gray-50 object-cover"
            >
        </div>
    @endif
</div>