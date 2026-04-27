<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="event_title" :value="__('Event Title')" />
        <x-text-input
            id="event_title"
            name="event_title"
            type="text"
            class="mt-1 block w-full"
            :value="old('event_title', $event->event_title ?? '')"
            required
        />
        <x-input-error :messages="$errors->get('event_title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="location" :value="__('Location')" />
        <x-text-input
            id="location"
            name="location"
            type="text"
            class="mt-1 block w-full"
            :value="old('location', $event->location ?? '')"
        />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="event_date" :value="__('Event Date')" />
        <x-text-input
            id="event_date"
            name="event_date"
            type="date"
            class="mt-1 block w-full"
            :value="old('event_date', isset($event) ? $event->event_date?->format('Y-m-d') : '')"
            required
        />
        <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="event_time" :value="__('Event Time')" />
        <x-text-input
            id="event_time"
            name="event_time"
            type="time"
            class="mt-1 block w-full"
            :value="old('event_time', $event->event_time ?? '')"
        />
        <x-input-error :messages="$errors->get('event_time')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="budget_used" :value="__('Budget Used')" />
        <x-text-input
            id="budget_used"
            name="budget_used"
            type="number"
            step="0.01"
            min="0"
            class="mt-1 block w-full"
            :value="old('budget_used', $event->budget_used ?? '')"
            placeholder="Optional"
        />
        <x-input-error :messages="$errors->get('budget_used')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="event_image" :value="__('Event Image')" />
        <input
            id="event_image"
            name="event_image"
            type="file"
            accept="image/png,image/jpeg,image/jpg"
            class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-[#6B0F1A] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#4A0A12]"
        />
        <p class="mt-1 text-xs text-gray-500">
            Accepted formats: JPG, JPEG, PNG. Max size: 2MB.
        </p>
        <x-input-error :messages="$errors->get('event_image')" class="mt-2" />
    </div>
</div>

@if (isset($event) && $event->event_image)
    <div>
        <p class="mb-2 text-sm font-medium text-gray-700">Current Event Image</p>
        <img
            src="{{ asset('storage/' . $event->event_image) }}"
            alt="{{ $event->event_title }}"
            class="h-40 w-full rounded-xl object-cover border border-gray-200"
        >
    </div>
@endif

<div>
    <x-input-label for="description" :value="__('Description')" />
    <textarea
        id="description"
        name="description"
        rows="6"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
        required
    >{{ old('description', $event->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>