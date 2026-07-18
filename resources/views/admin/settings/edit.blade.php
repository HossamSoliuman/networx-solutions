<x-layouts.admin title="Settings">
    <x-admin.page-header title="Settings"
        subtitle="Company details used across the website, contact page, and outgoing email." />

    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6">
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
                    <x-form.input id="contact_phone" name="contact_phone"
                        :value="old('contact_phone', $settings['contact_phone'])" class="mt-1.5" />
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
                    <x-form.input id="facebook_url" name="facebook_url" placeholder="https://facebook.com/…"
                        :value="old('facebook_url', $settings['facebook_url'])" class="mt-1.5" />
                    <x-form.error field="facebook_url" />
                </div>
                <div>
                    <x-form.label for="linkedin_url">LinkedIn</x-form.label>
                    <x-form.input id="linkedin_url" name="linkedin_url" placeholder="https://linkedin.com/company/…"
                        :value="old('linkedin_url', $settings['linkedin_url'])" class="mt-1.5" />
                    <x-form.error field="linkedin_url" />
                </div>
                <div>
                    <x-form.label for="instagram_url">Instagram</x-form.label>
                    <x-form.input id="instagram_url" name="instagram_url" placeholder="https://instagram.com/…"
                        :value="old('instagram_url', $settings['instagram_url'])" class="mt-1.5" />
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
                    <p class="mt-1.5 text-xs text-slate-400">Each new contact form submission sends an alert to this address. Leave empty to disable.</p>
                    <x-form.error field="notification_email" />
                </div>
                <div>
                    <x-form.label for="mail_signature">Email reply signature</x-form.label>
                    <x-form.textarea id="mail_signature" name="mail_signature" rows="3" class="mt-1.5">{{ old('mail_signature', $settings['mail_signature']) }}</x-form.textarea>
                    <p class="mt-1.5 text-xs text-slate-400">Appended to every reply sent from the messages screen.</p>
                    <x-form.error field="mail_signature" />
                </div>
            </div>
        </x-card>

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="check">Save settings</x-button>
        </div>
    </form>
</x-layouts.admin>
