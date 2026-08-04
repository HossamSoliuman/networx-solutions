{{-- Shared fields for create/edit. Expects $technology. --}}
<div class="grid grid-cols-1 gap-5">
    <div>
        <x-form.label for="name">Name</x-form.label>
        <x-form.input id="name" name="name" :value="old('name', $technology->name)" required class="mt-1.5" />
        <p class="mt-1.5 text-xs text-slate-400">Vendor or product name, shown as the logo's alternative text.</p>
        <x-form.error field="name" />
    </div>

    <div>
        <x-form.label for="slug">Slug</x-form.label>
        <x-form.input id="slug" name="slug" :value="old('slug', $technology->slug)"
            placeholder="auto-generated from the name" class="mt-1.5" />
        <x-form.error field="slug" />
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div>
            <x-form.label for="logo">Logo</x-form.label>
            <input id="logo" name="logo" type="file" accept=".svg,.png,.webp,.jpg,.jpeg"
                class="mt-1.5 block w-full rounded-lg bg-white text-sm text-slate-600 file:mr-4 file:rounded-l-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100">
            <p class="mt-1.5 text-xs text-slate-400">
                SVG works best. Transparent PNG or WebP up to 2 MB also works.
                Without a logo the website shows the name as a coloured wordmark.
            </p>
            <x-form.error field="logo" />
        </div>

        <div>
            <x-form.label>Current logo</x-form.label>
            <div class="mt-1.5 flex h-24 items-center justify-center rounded-xl bg-white px-4 ring-1 ring-slate-200">
                @if ($technology->logoUrl())
                    <img src="{{ $technology->logoUrl() }}" alt="{{ $technology->name }}" class="max-h-12 w-auto max-w-full object-contain">
                @else
                    <span class="font-display text-xl font-bold" style="color: {{ $technology->brand_color ?? '#0F172A' }}">
                        {{ $technology->name ?: 'No logo yet' }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div>
            <x-form.label for="brand_color">Brand colour</x-form.label>
            <div class="mt-1.5 flex items-center gap-3">
                <input id="brand_color" name="brand_color" type="color"
                    value="{{ old('brand_color', $technology->brand_color ?? '#0F172A') }}"
                    class="h-11 w-16 cursor-pointer rounded-lg border border-slate-300 bg-white p-1">
                <span class="text-xs text-slate-400">Used for the wordmark fallback and the card hover accent.</span>
            </div>
            <x-form.error field="brand_color" />
        </div>

        <div>
            <x-form.label for="website_url">Website <span class="font-normal text-slate-400">(optional)</span></x-form.label>
            <x-form.input id="website_url" name="website_url" type="url" placeholder="https://example.com"
                :value="old('website_url', $technology->website_url)" class="mt-1.5" />
            <p class="mt-1.5 text-xs text-slate-400">When set, the logo links to the vendor website in a new tab.</p>
            <x-form.error field="website_url" />
        </div>
    </div>

    <div class="flex flex-wrap items-end gap-5 border-t border-slate-200 pt-5">
        <div class="w-32">
            <x-form.label for="sort_order">Sort order</x-form.label>
            <x-form.input id="sort_order" name="sort_order" type="number" min="0"
                :value="old('sort_order', $technology->sort_order ?? 0)" required class="mt-1.5" />
            <x-form.error field="sort_order" />
        </div>

        <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600"
                @checked(old('is_active', $technology->is_active ?? true))>
            Visible on the website
        </label>
    </div>
</div>
