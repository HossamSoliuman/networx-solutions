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

    <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h2 class="font-display text-base font-bold text-navy-950">Pricing section</h2>
                <p class="mt-1 text-xs text-slate-500">
                    The headings above the plan cards on this service page.
                    @if ($service->exists)
                        The cards themselves are managed under
                        <a href="{{ route('admin.services.plans.index', $service) }}" class="font-semibold text-brand-700 hover:underline">pricing plans</a>.
                    @else
                        You can add the plan cards after the service is created.
                    @endif
                </p>
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="hidden" name="pricing_enabled" value="0">
                <input type="checkbox" name="pricing_enabled" value="1"
                    class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600"
                    @checked(old('pricing_enabled', $service->pricing_enabled ?? true))>
                Show the pricing section
            </label>
        </div>

        <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div class="space-y-4">
                <div>
                    <x-form.label for="pricing_eyebrow">Eyebrow</x-form.label>
                    <x-form.input id="pricing_eyebrow" name="pricing_eyebrow" :value="old('pricing_eyebrow', $service->pricing_eyebrow)"
                        placeholder="Pricing plans" class="mt-1.5" />
                    <x-form.error field="pricing_eyebrow" />
                </div>

                <div>
                    <x-form.label for="pricing_title">Heading</x-form.label>
                    <x-form.input id="pricing_title" name="pricing_title" :value="old('pricing_title', $service->pricing_title)"
                        placeholder="IT Support Plans" class="mt-1.5" />
                    <x-form.error field="pricing_title" />
                </div>

                <div>
                    <x-form.label for="pricing_subtitle">Sub-heading</x-form.label>
                    <x-form.input id="pricing_subtitle" name="pricing_subtitle" :value="old('pricing_subtitle', $service->pricing_subtitle)"
                        placeholder="Simple, reliable plans designed to fit your business." class="mt-1.5" />
                    <x-form.error field="pricing_subtitle" />
                </div>

                <div>
                    <x-form.label for="pricing_yearly_note">Yearly note <span class="font-normal text-slate-400">(next to the monthly/yearly switch)</span></x-form.label>
                    <x-form.input id="pricing_yearly_note" name="pricing_yearly_note" :value="old('pricing_yearly_note', $service->pricing_yearly_note)"
                        placeholder="Save up to 15% with annual plans" class="mt-1.5" />
                    <x-form.error field="pricing_yearly_note" />
                </div>

                <div>
                    <x-form.label for="pricing_footnote">Footnote</x-form.label>
                    <x-form.textarea id="pricing_footnote" name="pricing_footnote" rows="2" class="mt-1.5"
                        placeholder="* Hardware, software and licenses are billed separately.">{{ old('pricing_footnote', $service->pricing_footnote) }}</x-form.textarea>
                    <x-form.error field="pricing_footnote" />
                </div>
            </div>

            <div class="space-y-4 rounded-lg border border-blue-200 bg-blue-50/60 p-4" dir="rtl">
                <div>
                    <x-form.label for="pricing_eyebrow_ar">العنوان التمهيدي</x-form.label>
                    <x-form.input id="pricing_eyebrow_ar" name="pricing_eyebrow_ar" :value="old('pricing_eyebrow_ar', $service->pricing_eyebrow_ar)"
                        class="mt-1.5 text-right" dir="rtl" />
                    <x-form.error field="pricing_eyebrow_ar" />
                </div>

                <div>
                    <x-form.label for="pricing_title_ar">العنوان الرئيسي</x-form.label>
                    <x-form.input id="pricing_title_ar" name="pricing_title_ar" :value="old('pricing_title_ar', $service->pricing_title_ar)"
                        class="mt-1.5 text-right" dir="rtl" />
                    <x-form.error field="pricing_title_ar" />
                </div>

                <div>
                    <x-form.label for="pricing_subtitle_ar">العنوان الفرعي</x-form.label>
                    <x-form.input id="pricing_subtitle_ar" name="pricing_subtitle_ar" :value="old('pricing_subtitle_ar', $service->pricing_subtitle_ar)"
                        class="mt-1.5 text-right" dir="rtl" />
                    <x-form.error field="pricing_subtitle_ar" />
                </div>

                <div>
                    <x-form.label for="pricing_yearly_note_ar">ملاحظة الاشتراك السنوي</x-form.label>
                    <x-form.input id="pricing_yearly_note_ar" name="pricing_yearly_note_ar" :value="old('pricing_yearly_note_ar', $service->pricing_yearly_note_ar)"
                        class="mt-1.5 text-right" dir="rtl" />
                    <x-form.error field="pricing_yearly_note_ar" />
                </div>

                <div>
                    <x-form.label for="pricing_footnote_ar">الحاشية</x-form.label>
                    <x-form.textarea id="pricing_footnote_ar" name="pricing_footnote_ar" rows="2" class="mt-1.5 text-right" dir="rtl">{{ old('pricing_footnote_ar', $service->pricing_footnote_ar) }}</x-form.textarea>
                    <x-form.error field="pricing_footnote_ar" />
                </div>
            </div>
        </div>
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
