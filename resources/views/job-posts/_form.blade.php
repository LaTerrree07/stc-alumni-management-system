<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="company_name" :value="__('Company Name')" />
        <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full"
            :value="old('company_name', $jobPost->company_name ?? '')" required />
        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="job_title" :value="__('Job Title')" />
        <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full"
            :value="old('job_title', $jobPost->job_title ?? '')" required />
        <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="job_type" :value="__('Job Type')" />
        <x-text-input id="job_type" name="job_type" type="text" class="mt-1 block w-full"
            :value="old('job_type', $jobPost->job_type ?? '')" placeholder="Full-time, Part-time, Contract" />
        <x-input-error :messages="$errors->get('job_type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="location" :value="__('Location')" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
            :value="old('location', $jobPost->location ?? '')" />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="salary_range" :value="__('Salary Range')" />
        <x-text-input id="salary_range" name="salary_range" type="text" class="mt-1 block w-full"
            :value="old('salary_range', $jobPost->salary_range ?? '')" placeholder="Example: ₱20,000 - ₱30,000" />
        <x-input-error :messages="$errors->get('salary_range')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="application_link" :value="__('Application Link')" />
        <x-text-input id="application_link" name="application_link" type="url" class="mt-1 block w-full"
            :value="old('application_link', $jobPost->application_link ?? '')" placeholder="https://example.com/apply" />
        <x-input-error :messages="$errors->get('application_link')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="description" :value="__('Job Description')" />
    <textarea
        id="description"
        name="description"
        rows="5"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
        required
    >{{ old('description', $jobPost->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div>
    <x-input-label for="requirements" :value="__('Job Requirements')" />
    <textarea
        id="requirements"
        name="requirements"
        rows="5"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
    >{{ old('requirements', $jobPost->requirements ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
</div>