@extends('layouts.admin')

@section('title', 'SEO & AI search')

@section('content')
    <x-admin.page-header title="SEO &amp; AI search"
        subtitle="How the site appears in Google results and in AI assistants like ChatGPT, Claude, and Perplexity." />

    <form method="POST" action="{{ route('admin.settings.update', 'seo') }}" class="max-w-5xl space-y-6">
        @csrf @method('PUT')

        <x-card title="Search engines">
            <div class="space-y-5">
                <div>
                    <x-form.label for="seo_meta_title">Meta title</x-form.label>
                    <x-form.input id="seo_meta_title" name="seo_meta_title" :value="old('seo_meta_title', $settings['seo_meta_title'])" class="mt-1.5" />
                    <p class="mt-1.5 text-xs text-slate-400">The browser-tab and search-result title for the home page. Around 60 characters works best.</p>
                    <x-form.error field="seo_meta_title" />
                </div>
                <div>
                    <x-form.label for="seo_meta_description">Meta description</x-form.label>
                    <x-form.textarea id="seo_meta_description" name="seo_meta_description" rows="3" class="mt-1.5">{{ old('seo_meta_description', $settings['seo_meta_description']) }}</x-form.textarea>
                    <p class="mt-1.5 text-xs text-slate-400">The snippet shown under the site in search results. Aim for 150–160 characters.</p>
                    <x-form.error field="seo_meta_description" />
                </div>
                <div>
                    <x-form.label for="seo_keywords">Keywords</x-form.label>
                    <x-form.input id="seo_keywords" name="seo_keywords" :value="old('seo_keywords', $settings['seo_keywords'])" class="mt-1.5" />
                    <p class="mt-1.5 text-xs text-slate-400">Comma-separated topics the business should be found for.</p>
                    <x-form.error field="seo_keywords" />
                </div>
            </div>
        </x-card>

        <x-card title="AI search (ChatGPT, Claude, Perplexity…)">
            <div class="space-y-5">
                <p class="text-sm leading-6 text-slate-500">
                    AI assistants answer questions like <span class="font-medium text-slate-700">“Who provides IT support in Riyadh?”</span>
                    from what their crawlers read here. The site publishes structured data on every page plus an
                    <span class="font-medium text-slate-700">llms.txt</span> summary written specifically for AI crawlers,
                    so assistants can describe the company accurately and recommend it.
                </p>
                <div>
                    <x-form.label for="ai_summary">Company summary for AI assistants</x-form.label>
                    <x-form.textarea id="ai_summary" name="ai_summary" rows="5" class="mt-1.5">{{ old('ai_summary', $settings['ai_summary']) }}</x-form.textarea>
                    <p class="mt-1.5 text-xs text-slate-400">
                        Plain language, no marketing fluff: what the company does, for whom, and where. This is what an AI is most likely to repeat.
                    </p>
                    <x-form.error field="ai_summary" />
                </div>
                <label for="ai_allow_crawlers" class="flex items-start gap-3">
                    <input type="hidden" name="ai_allow_crawlers" value="0">
                    <input id="ai_allow_crawlers" name="ai_allow_crawlers" type="checkbox" value="1"
                        @checked(old('ai_allow_crawlers', $settings['ai_allow_crawlers']) === '1')
                        class="mt-0.5 size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600">
                    <span class="text-sm text-slate-700">
                        Allow AI crawlers
                        <span class="block text-xs text-slate-400">Lets GPTBot (ChatGPT), ClaudeBot (Claude), PerplexityBot, and similar crawlers index the site via robots.txt. Turning this off blocks them.</span>
                    </span>
                </label>
                <x-form.error field="ai_allow_crawlers" />

                <div class="rounded-lg bg-slate-50 p-4 text-xs leading-6 text-slate-500 ring-1 ring-inset ring-slate-200">
                    <p class="font-semibold text-slate-700">What crawlers see</p>
                    <div class="mt-1.5 flex flex-wrap gap-x-5 gap-y-1">
                        <a href="{{ route('seo.llms') }}" target="_blank" class="font-medium text-brand-600 hover:text-brand-700">llms.txt — AI summary</a>
                        <a href="{{ route('seo.sitemap') }}" target="_blank" class="font-medium text-brand-600 hover:text-brand-700">sitemap.xml — all pages</a>
                        <a href="{{ route('seo.robots') }}" target="_blank" class="font-medium text-brand-600 hover:text-brand-700">robots.txt — crawler rules</a>
                    </div>
                </div>
            </div>
        </x-card>

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="check">Save SEO settings</x-button>
        </div>
    </form>
@endsection
