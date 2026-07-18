{{-- Shared fields for create/edit. Expects $service. --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <x-form.label for="name">Name</x-form.label>
        <x-form.input id="name" name="name" :value="old('name', $service->name)" required class="mt-1.5" />
        <x-form.error field="name" />
    </div>

    <div>
        <x-form.label for="slug">Slug</x-form.label>
        <x-form.input id="slug" name="slug" :value="old('slug', $service->slug)" placeholder="auto-generated from name" class="mt-1.5" />
        <x-form.error field="slug" />
    </div>
</div>

<div>
    <x-form.label>Icon</x-form.label>
    <div class="mt-2 flex flex-wrap gap-2">
        @foreach (['headset' => 'Headset', 'network' => 'Network', 'cloud' => 'Cloud', 'shield' => 'Shield', 'camera' => 'Camera', 'grid' => 'Grid', 'cog' => 'Cog', 'globe' => 'Globe'] as $icon => $label)
            <label class="flex cursor-pointer items-center gap-2 rounded-lg px-3 py-2 text-sm ring-1 ring-inset ring-slate-300 transition-colors has-checked:bg-brand-50 has-checked:text-brand-700 has-checked:ring-brand-600 hover:bg-slate-50">
                <input type="radio" name="icon" value="{{ $icon }}" class="sr-only"
                    @checked(old('icon', $service->icon ?? 'cog') === $icon)>
                <x-icon :name="$icon" class="size-4" />
                {{ $label }}
            </label>
        @endforeach
    </div>
    <x-form.error field="icon" />
</div>

<div>
    <x-form.label for="excerpt">Excerpt <span class="font-normal text-slate-400">(short line shown on cards)</span></x-form.label>
    <x-form.input id="excerpt" name="excerpt" :value="old('excerpt', $service->excerpt)" required class="mt-1.5" />
    <x-form.error field="excerpt" />
</div>

<div>
    <x-form.label for="description">Description</x-form.label>
    <x-form.textarea id="description" name="description" rows="4" class="mt-1.5">{{ old('description', $service->description) }}</x-form.textarea>
    <x-form.error field="description" />
</div>

<div class="flex flex-wrap items-end gap-5">
    <div class="w-32">
        <x-form.label for="sort_order">Sort order</x-form.label>
        <x-form.input id="sort_order" name="sort_order" type="number" min="0"
            :value="old('sort_order', $service->sort_order ?? 0)" required class="mt-1.5" />
        <x-form.error field="sort_order" />
    </div>

    <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1"
            class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600"
            @checked(old('is_active', $service->is_active ?? true))>
        Visible on the website
    </label>
</div>
