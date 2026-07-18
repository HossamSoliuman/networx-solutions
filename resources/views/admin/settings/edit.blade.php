<x-layouts.admin title="Website content">
    <x-admin.page-header title="Website content"
        subtitle="Manage public page copy, machine photography, company details, and messaging." />

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="max-w-5xl space-y-6">
        @csrf @method('PUT')

        <x-card title="Company identity">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-form.label for="site_name">Company name</x-form.label>
                    <x-form.input id="site_name" name="site_name" :value="old('site_name', $settings['site_name'])" required class="mt-1.5" />
                    <x-form.error field="site_name" />
                </div>
                <div>
                    <x-form.label for="tagline">Tagline</x-form.label>
                    <x-form.input id="tagline" name="tagline" :value="old('tagline', $settings['tagline'])" class="mt-1.5" />
                    <x-form.error field="tagline" />
                </div>
            </div>
        </x-card>

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

        <x-card title="Contact details">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-form.label for="contact_email">Public email</x-form.label>
                    <x-form.input id="contact_email" name="contact_email" type="email"
                        :value="old('contact_email', $settings['contact_email'])" required class="mt-1.5" />
                    <x-form.error field="contact_email" />
                </div>
                <div>
                    <x-form.label for="contact_phone">Phone</x-form.label>
                    <x-form.input id="contact_phone" name="contact_phone" :value="old('contact_phone', $settings['contact_phone'])" class="mt-1.5" />
                    <x-form.error field="contact_phone" />
                </div>
                <div>
                    <x-form.label for="address">Address</x-form.label>
                    <x-form.input id="address" name="address" :value="old('address', $settings['address'])" class="mt-1.5" />
                    <x-form.error field="address" />
                </div>
                <div>
                    <x-form.label for="website">Website</x-form.label>
                    <x-form.input id="website" name="website" :value="old('website', $settings['website'])" class="mt-1.5" />
                    <x-form.error field="website" />
                </div>
            </div>
        </x-card>

        <x-card title="Social profiles">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div>
                    <x-form.label for="facebook_url">Facebook</x-form.label>
                    <x-form.input id="facebook_url" name="facebook_url" :value="old('facebook_url', $settings['facebook_url'])" class="mt-1.5" />
                    <x-form.error field="facebook_url" />
                </div>
                <div>
                    <x-form.label for="linkedin_url">LinkedIn</x-form.label>
                    <x-form.input id="linkedin_url" name="linkedin_url" :value="old('linkedin_url', $settings['linkedin_url'])" class="mt-1.5" />
                    <x-form.error field="linkedin_url" />
                </div>
                <div>
                    <x-form.label for="instagram_url">Instagram</x-form.label>
                    <x-form.input id="instagram_url" name="instagram_url" :value="old('instagram_url', $settings['instagram_url'])" class="mt-1.5" />
                    <x-form.error field="instagram_url" />
                </div>
            </div>
        </x-card>

        <x-card title="Messaging">
            <div class="space-y-5">
                <div>
                    <x-form.label for="notification_email">New-message alerts go to</x-form.label>
                    <x-form.input id="notification_email" name="notification_email" type="email"
                        :value="old('notification_email', $settings['notification_email'])" class="mt-1.5" />
                    <x-form.error field="notification_email" />
                </div>
                <div>
                    <x-form.label for="mail_signature">Email reply signature</x-form.label>
                    <x-form.textarea id="mail_signature" name="mail_signature" rows="3" class="mt-1.5">{{ old('mail_signature', $settings['mail_signature']) }}</x-form.textarea>
                    <x-form.error field="mail_signature" />
                </div>
            </div>
        </x-card>

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="check">Save website content</x-button>
        </div>
    </form>
</x-layouts.admin>
