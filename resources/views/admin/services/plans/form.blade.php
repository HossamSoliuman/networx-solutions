{{-- Shared fields for create/edit. Expects $service and $plan. --}}
<section class="rounded-xl border border-slate-200 bg-slate-50/70 p-5">
    <div class="mb-5 flex items-center justify-between gap-4">
        <div>
            <h2 class="font-display text-base font-bold text-navy-950">English content</h2>
            <p class="mt-1 text-xs text-slate-500">Used for the English website and as the fallback for missing Arabic content.</p>
        </div>
        <span class="rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-700">EN</span>
    </div>

    <div class="grid grid-cols-1 gap-5">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-form.label for="name">Plan name</x-form.label>
                <x-form.input id="name" name="name" :value="old('name', $plan->name)" required class="mt-1.5"
                    placeholder="Essential Care" />
                <x-form.error field="name" />
            </div>

            <div>
                <x-form.label for="capacity">Capacity line <span class="font-normal text-slate-400">(optional)</span></x-form.label>
                <x-form.input id="capacity" name="capacity" :value="old('capacity', $plan->capacity)" class="mt-1.5"
                    placeholder="Up to 20 Devices" />
                <p class="mt-1.5 text-xs text-slate-400">Shown under the price, between two dividing lines.</p>
                <x-form.error field="capacity" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-form.label for="badge">Ribbon text <span class="font-normal text-slate-400">(optional)</span></x-form.label>
                <x-form.input id="badge" name="badge" :value="old('badge', $plan->badge)" class="mt-1.5"
                    placeholder="Most Popular" />
                <x-form.error field="badge" />
            </div>

            <div>
                <x-form.label for="cta_label">Button label <span class="font-normal text-slate-400">(optional)</span></x-form.label>
                <x-form.input id="cta_label" name="cta_label" :value="old('cta_label', $plan->cta_label)" class="mt-1.5"
                    placeholder="Get started" />
                <x-form.error field="cta_label" />
            </div>
        </div>

        <div>
            <x-form.label for="features">Features <span class="font-normal text-slate-400">(one per line)</span></x-form.label>
            <x-form.textarea id="features" name="features" rows="8" class="mt-1.5"
                placeholder="Everything in Starter Care&#10;2 On-site Visits / month&#10;Monthly IT Report">{{ old('features', $plan->features) }}</x-form.textarea>
            <x-form.error field="features" />
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
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-form.label for="name_ar">اسم الباقة</x-form.label>
                <x-form.input id="name_ar" name="name_ar" :value="old('name_ar', $plan->name_ar)" class="mt-1.5 text-right" dir="rtl" />
                <x-form.error field="name_ar" />
            </div>

            <div>
                <x-form.label for="capacity_ar">سطر السعة</x-form.label>
                <x-form.input id="capacity_ar" name="capacity_ar" :value="old('capacity_ar', $plan->capacity_ar)" class="mt-1.5 text-right" dir="rtl" />
                <x-form.error field="capacity_ar" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-form.label for="badge_ar">نص الشريط</x-form.label>
                <x-form.input id="badge_ar" name="badge_ar" :value="old('badge_ar', $plan->badge_ar)" class="mt-1.5 text-right" dir="rtl" />
                <x-form.error field="badge_ar" />
            </div>

            <div>
                <x-form.label for="cta_label_ar">نص الزر</x-form.label>
                <x-form.input id="cta_label_ar" name="cta_label_ar" :value="old('cta_label_ar', $plan->cta_label_ar)" class="mt-1.5 text-right" dir="rtl" />
                <x-form.error field="cta_label_ar" />
            </div>
        </div>

        <div>
            <x-form.label for="features_ar">المميزات <span class="font-normal text-slate-400">(ميزة في كل سطر)</span></x-form.label>
            <x-form.textarea id="features_ar" name="features_ar" rows="8" class="mt-1.5 text-right" dir="rtl">{{ old('features_ar', $plan->features_ar) }}</x-form.textarea>
            <x-form.error field="features_ar" />
        </div>
    </div>
</section>

<section class="space-y-5 border-t border-slate-200 pt-5">
    <h2 class="font-display text-base font-bold text-navy-950">Pricing</h2>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <x-form.label for="price_monthly">Monthly price</x-form.label>
            <x-form.input id="price_monthly" name="price_monthly" type="number" min="0" step="0.01"
                :value="old('price_monthly', $plan->price_monthly)" class="mt-1.5" placeholder="1999" />
            <x-form.error field="price_monthly" />
        </div>

        <div>
            <x-form.label for="price_yearly">Yearly price <span class="font-normal text-slate-400">(optional)</span></x-form.label>
            <x-form.input id="price_yearly" name="price_yearly" type="number" min="0" step="0.01"
                :value="old('price_yearly', $plan->price_yearly)" class="mt-1.5" placeholder="20390" />
            <p class="mt-1.5 text-xs text-slate-400">Leave empty to hide this plan from the yearly view.</p>
            <x-form.error field="price_yearly" />
        </div>

        <div>
            <x-form.label for="currency">Currency</x-form.label>
            <x-form.input id="currency" name="currency" :value="old('currency', $plan->currency ?? 'EGP')" required class="mt-1.5" />
            <x-form.error field="currency" />
        </div>

        <div>
            <x-form.label for="price_suffix">Price suffix <span class="font-normal text-slate-400">(optional)</span></x-form.label>
            <x-form.input id="price_suffix" name="price_suffix" :value="old('price_suffix', $plan->price_suffix)" class="mt-1.5"
                placeholder="+" />
            <p class="mt-1.5 text-xs text-slate-400">Shown right after the number, e.g. “15,000+”.</p>
            <x-form.error field="price_suffix" />
        </div>
    </div>

    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-inset ring-slate-200">
        <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
            <input type="hidden" name="is_custom_price" value="0">
            <input type="checkbox" name="is_custom_price" value="1"
                class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600"
                @checked(old('is_custom_price', $plan->is_custom_price))>
            Quote this plan individually — hide the numbers
        </label>

        <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-form.label for="custom_price_label">Text shown instead of a price</x-form.label>
                <x-form.input id="custom_price_label" name="custom_price_label"
                    :value="old('custom_price_label', $plan->custom_price_label)" class="mt-1.5" placeholder="Custom" />
                <x-form.error field="custom_price_label" />
            </div>

            <div dir="rtl">
                <x-form.label for="custom_price_label_ar">النص البديل للسعر</x-form.label>
                <x-form.input id="custom_price_label_ar" name="custom_price_label_ar"
                    :value="old('custom_price_label_ar', $plan->custom_price_label_ar)" class="mt-1.5 text-right" dir="rtl" />
                <x-form.error field="custom_price_label_ar" />
            </div>
        </div>
    </div>

    <div>
        <x-form.label>Icon</x-form.label>
        <div class="mt-2 flex flex-wrap gap-2">
            @foreach (['star' => 'Star', 'desktop' => 'Desktop', 'users' => 'Users', 'building' => 'Building', 'server' => 'Server', 'shield' => 'Shield', 'cloud' => 'Cloud', 'network' => 'Network', 'headset' => 'Headset', 'gauge' => 'Gauge', 'lock' => 'Lock', 'cog' => 'Cog'] as $icon => $label)
                <label class="flex cursor-pointer items-center gap-2 rounded-lg px-3 py-2 text-sm ring-1 ring-inset ring-slate-300 transition-colors has-checked:bg-brand-50 has-checked:text-brand-700 has-checked:ring-brand-600 hover:bg-slate-50">
                    <input type="radio" name="icon" value="{{ $icon }}" class="sr-only"
                        @checked(old('icon', $plan->icon ?? 'star') === $icon)>
                    <x-icon :name="$icon" class="size-4" />
                    {{ $label }}
                </label>
            @endforeach
        </div>
        <x-form.error field="icon" />
    </div>

    <div class="flex flex-wrap items-end gap-6">
        <div>
            <x-form.label for="accent_color">Accent colour</x-form.label>
            <div class="mt-1.5 flex items-center gap-3">
                <input id="accent_color" name="accent_color" type="color"
                    value="{{ old('accent_color', $plan->accent_color ?? '#0045B3') }}"
                    class="h-11 w-16 cursor-pointer rounded-lg border border-slate-300 bg-white p-1">
                <span class="text-xs text-slate-400">Colours the icon, price, ticks, and button.</span>
            </div>
            <x-form.error field="accent_color" />
        </div>

        <div class="w-32">
            <x-form.label for="sort_order">Sort order</x-form.label>
            <x-form.input id="sort_order" name="sort_order" type="number" min="0"
                :value="old('sort_order', $plan->sort_order ?? 0)" required class="mt-1.5" />
            <x-form.error field="sort_order" />
        </div>

        <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1"
                class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600"
                @checked(old('is_featured', $plan->is_featured))>
            Highlight as the recommended plan
        </label>

        <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600"
                @checked(old('is_active', $plan->is_active ?? true))>
            Visible on the website
        </label>
    </div>
</section>
