{{-- Shared fields for create/edit. Expects $service. --}}
<section class="rounded-xl border border-slate-200 bg-slate-50/70 p-5">
    <div class="mb-5 flex items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-base font-bold text-navy-950">English content</h2>
            <p class="mt-1 text-xs text-slate-500">Used for the English website and as the fallback for missing Arabic content.</p>
        </div>
        <span class="rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-700">EN</span>
    </div>

    <div class="grid grid-cols-1 gap-5">
        <div>
            <x-form.label for="name">Name</x-form.label>
            <x-form.input id="name" name="name" :value="old('name', $service->name)" required class="mt-1.5" />
            <x-form.error field="name" />
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

        <div>
            <x-form.label for="benefits">Service inclusions <span class="font-normal text-slate-400">(one per line)</span></x-form.label>
            <x-form.textarea id="benefits" name="benefits" rows="5" class="mt-1.5">{{ old('benefits', $service->benefits) }}</x-form.textarea>
            <x-form.error field="benefits" />
        </div>
    </div>
</section>

<section class="rounded-xl border border-blue-200 bg-blue-50/60 p-5" dir="rtl">
    <div class="mb-5 flex items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-base font-bold text-navy-950">المحتوى العربي</h2>
            <p class="mt-1 text-xs text-slate-500">يظهر عند اختيار اللغة العربية. الحقول الفارغة تستخدم المحتوى الإنجليزي تلقائيًا.</p>
        </div>
        <span class="rounded-full bg-brand-600 px-3 py-1 text-xs font-bold text-white">AR</span>
    </div>

    <div class="grid grid-cols-1 gap-5">
        <div>
            <x-form.label for="name_ar">اسم الخدمة</x-form.label>
            <x-form.input id="name_ar" name="name_ar" :value="old('name_ar', $service->name_ar)" class="mt-1.5 text-right" dir="rtl" />
            <x-form.error field="name_ar" />
        </div>

        <div>
            <x-form.label for="excerpt_ar">النبذة المختصرة</x-form.label>
            <x-form.input id="excerpt_ar" name="excerpt_ar" :value="old('excerpt_ar', $service->excerpt_ar)" class="mt-1.5 text-right" dir="rtl" />
            <x-form.error field="excerpt_ar" />
        </div>

        <div>
            <x-form.label for="description_ar">الوصف</x-form.label>
            <x-form.textarea id="description_ar" name="description_ar" rows="4" class="mt-1.5 text-right" dir="rtl">{{ old('description_ar', $service->description_ar) }}</x-form.textarea>
            <x-form.error field="description_ar" />
        </div>

        <div>
            <x-form.label for="benefits_ar">محتويات الخدمة <span class="font-normal text-slate-400">(عنصر في كل سطر)</span></x-form.label>
            <x-form.textarea id="benefits_ar" name="benefits_ar" rows="5" class="mt-1.5 text-right" dir="rtl">{{ old('benefits_ar', $service->benefits_ar) }}</x-form.textarea>
            <x-form.error field="benefits_ar" />
        </div>
    </div>
</section>

<section class="space-y-5 border-t border-slate-200 pt-5">
    <div>
        <x-form.label for="slug">Slug</x-form.label>
        <x-form.input id="slug" name="slug" :value="old('slug', $service->slug)" placeholder="auto-generated from the English name" class="mt-1.5" />
        <x-form.error field="slug" />
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

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div>
            <x-form.label for="image">Service image</x-form.label>
            <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp"
                class="mt-1.5 block w-full rounded-lg bg-white text-sm text-slate-600 file:mr-4 file:rounded-l-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100">
            <p class="mt-1.5 text-xs text-slate-400">Real equipment photography works best. JPG, PNG, or WebP up to 5 MB.</p>
            <x-form.error field="image" />
        </div>

        @if ($service->exists && $service->image_path)
            <div>
                <x-form.label>Current image</x-form.label>
                <img src="{{ $service->imageUrl() }}" alt="" class="mt-1.5 h-32 w-full rounded-xl object-cover ring-1 ring-slate-200">
            </div>
        @endif
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
</section>
