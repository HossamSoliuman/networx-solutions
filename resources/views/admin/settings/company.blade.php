@extends('layouts.admin')

@section('title', 'Company info')

@section('content')
    <x-admin.page-header title="Company info"
        subtitle="Identity, contact details, and social profiles shown across the site." />

    <form method="POST" action="{{ route('admin.settings.update', 'company') }}" class="max-w-5xl space-y-6">
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

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="check">Save company info</x-button>
        </div>
    </form>
@endsection
