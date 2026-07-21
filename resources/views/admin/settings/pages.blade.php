@extends('layouts.admin')

@section('title', 'Page content')

@section('content')
    <x-admin.page-header title="Page content"
        subtitle="Copy and machine photography for every public page." />

    <form method="POST" action="{{ route('admin.settings.update', 'pages') }}" enctype="multipart/form-data" class="max-w-5xl space-y-6">
        @csrf @method('PUT')

        <x-card title="Home page">
            <div class="space-y-5">
                <div>
                    <x-form.label for="home_eyebrow">Eyebrow</x-form.label>
                    <x-form.input id="home_eyebrow" name="home_eyebrow" :value="old('home_eyebrow', $settings['home_eyebrow'])" class="mt-1.5" />
                    <x-form.error field="home_eyebrow" />
                </div>
                <div>
                    <x-form.label for="home_title">Hero title</x-form.label>
                    <x-form.input id="home_title" name="home_title" :value="old('home_title', $settings['home_title'])" class="mt-1.5" />
                    <x-form.error field="home_title" />
                </div>
                <div>
                    <x-form.label for="home_intro">Hero introduction</x-form.label>
                    <x-form.textarea id="home_intro" name="home_intro" rows="3" class="mt-1.5">{{ old('home_intro', $settings['home_intro']) }}</x-form.textarea>
                    <x-form.error field="home_intro" />
                </div>
                <div class="grid gap-5 sm:grid-cols-[1fr_12rem]">
                    <div>
                        <x-form.label for="home_image">Hero machine image</x-form.label>
                        <input id="home_image" name="home_image" type="file" accept=".jpg,.jpeg,.png,.webp"
                            class="mt-1.5 block w-full rounded-lg bg-white text-sm text-slate-600 file:mr-4 file:rounded-l-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-700">
                        <p class="mt-1.5 text-xs text-slate-400">Use real camera photography of equipment only. Maximum 5 MB.</p>
                        <x-form.error field="home_image" />
                    </div>
                    <img src="{{ $settings['home_image_url'] }}" alt="" class="h-28 w-full rounded-xl object-cover ring-1 ring-slate-200">
                </div>
            </div>
        </x-card>

        <x-card title="Services page">
            <div class="space-y-5">
                <div>
                    <x-form.label for="services_title">Page title</x-form.label>
                    <x-form.input id="services_title" name="services_title" :value="old('services_title', $settings['services_title'])" class="mt-1.5" />
                    <x-form.error field="services_title" />
                </div>
                <div>
                    <x-form.label for="services_intro">Introduction</x-form.label>
                    <x-form.textarea id="services_intro" name="services_intro" rows="3" class="mt-1.5">{{ old('services_intro', $settings['services_intro']) }}</x-form.textarea>
                    <x-form.error field="services_intro" />
                </div>
                <p class="text-xs leading-5 text-slate-400">Individual service content and photography are managed from the Services section.</p>
            </div>
        </x-card>

        <x-card title="About page">
            <div class="space-y-5">
                <div>
                    <x-form.label for="about_eyebrow">Eyebrow</x-form.label>
                    <x-form.input id="about_eyebrow" name="about_eyebrow" :value="old('about_eyebrow', $settings['about_eyebrow'])" class="mt-1.5" />
                    <x-form.error field="about_eyebrow" />
                </div>
                <div>
                    <x-form.label for="about_title">Page title</x-form.label>
                    <x-form.input id="about_title" name="about_title" :value="old('about_title', $settings['about_title'])" class="mt-1.5" />
                    <x-form.error field="about_title" />
                </div>
                <div>
                    <x-form.label for="about_intro">Introduction</x-form.label>
                    <x-form.textarea id="about_intro" name="about_intro" rows="3" class="mt-1.5">{{ old('about_intro', $settings['about_intro']) }}</x-form.textarea>
                    <x-form.error field="about_intro" />
                </div>
                <div>
                    <x-form.label for="about_story">Company story</x-form.label>
                    <x-form.textarea id="about_story" name="about_story" rows="5" class="mt-1.5">{{ old('about_story', $settings['about_story']) }}</x-form.textarea>
                    <x-form.error field="about_story" />
                </div>
                <div class="grid gap-5 sm:grid-cols-[1fr_12rem]">
                    <div>
                        <x-form.label for="about_image">About machine image</x-form.label>
                        <input id="about_image" name="about_image" type="file" accept=".jpg,.jpeg,.png,.webp"
                            class="mt-1.5 block w-full rounded-lg bg-white text-sm text-slate-600 file:mr-4 file:rounded-l-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-700">
                        <x-form.error field="about_image" />
                    </div>
                    <img src="{{ $settings['about_image_url'] }}" alt="" class="h-28 w-full rounded-xl object-cover ring-1 ring-slate-200">
                </div>
            </div>
        </x-card>

        <x-card title="Contact page">
            <div class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-form.label for="contact_eyebrow">Eyebrow</x-form.label>
                        <x-form.input id="contact_eyebrow" name="contact_eyebrow" :value="old('contact_eyebrow', $settings['contact_eyebrow'])" class="mt-1.5" />
                        <x-form.error field="contact_eyebrow" />
                    </div>
                    <div>
                        <x-form.label for="contact_title">Page title</x-form.label>
                        <x-form.input id="contact_title" name="contact_title" :value="old('contact_title', $settings['contact_title'])" class="mt-1.5" />
                        <x-form.error field="contact_title" />
                    </div>
                </div>
                <div>
                    <x-form.label for="contact_intro">Introduction</x-form.label>
                    <x-form.textarea id="contact_intro" name="contact_intro" rows="3" class="mt-1.5">{{ old('contact_intro', $settings['contact_intro']) }}</x-form.textarea>
                    <x-form.error field="contact_intro" />
                </div>
                <div class="grid gap-5 sm:grid-cols-[1fr_12rem]">
                    <div>
                        <x-form.label for="contact_image">Contact machine image</x-form.label>
                        <input id="contact_image" name="contact_image" type="file" accept=".jpg,.jpeg,.png,.webp"
                            class="mt-1.5 block w-full rounded-lg bg-white text-sm text-slate-600 file:mr-4 file:rounded-l-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-700">
                        <x-form.error field="contact_image" />
                    </div>
                    <img src="{{ $settings['contact_image_url'] }}" alt="" class="h-28 w-full rounded-xl object-cover ring-1 ring-slate-200">
                </div>
            </div>
        </x-card>

        <x-card title="Call to action">
            <div class="space-y-5">
                <div>
                    <x-form.label for="cta_title">Heading</x-form.label>
                    <x-form.input id="cta_title" name="cta_title" :value="old('cta_title', $settings['cta_title'])" class="mt-1.5" />
                    <x-form.error field="cta_title" />
                </div>
                <div>
                    <x-form.label for="cta_intro">Supporting text</x-form.label>
                    <x-form.textarea id="cta_intro" name="cta_intro" rows="2" class="mt-1.5">{{ old('cta_intro', $settings['cta_intro']) }}</x-form.textarea>
                    <x-form.error field="cta_intro" />
                </div>
            </div>
        </x-card>

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="check">Save page content</x-button>
        </div>
    </form>
@endsection
