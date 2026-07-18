<x-layouts.admin title="Dashboard">
    <x-admin.page-header title="Dashboard"
        subtitle="Overview of enquiries and support activity for Networx Solutions.">
        <x-button :href="route('admin.messages.index')" variant="secondary" icon="inbox">Open inbox</x-button>
    </x-admin.page-header>

    @php
        $weekDelta = $previousWeek > 0
            ? round((($thisWeek - $previousWeek) / $previousWeek) * 100)
            : null;
    @endphp

    {{-- Stat tiles --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card label="Total messages" :value="number_format($totalMessages)" icon="envelope"
            :trend="$weekDelta === null ? null : ($weekDelta >= 0 ? '+'.$weekDelta.'%' : $weekDelta.'%')"
            :trend-up="($weekDelta ?? 0) >= 0" hint="vs. previous 7 days" />

        <x-admin.stat-card label="Unread" :value="number_format($unreadCount)" icon="eye"
            hint="waiting to be opened" />

        <x-admin.stat-card label="Awaiting reply" :value="number_format($awaitingReply)" icon="clock"
            hint="new + in progress" />

        <x-admin.stat-card label="Avg. first response" :value="$avgResponseHours === null ? '—' : $avgResponseHours.'h'"
            icon="reply" :hint="$repliedThisMonth.' replies sent this month'" />
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Volume chart --}}
        <x-card title="Messages received — last 30 days" class="lg:col-span-2" :padding="false">
            @php
                $n = count($dailyVolume);
                $peak = max(1, max(array_column($dailyVolume, 'count')));
                $left = 16; $right = 584; $top = 16; $bottom = 176;
                $step = ($right - $left) / max(1, $n - 1);

                $points = collect($dailyVolume)->map(fn (array $day, int $i) => [
                    'x' => round($left + $i * $step, 2),
                    'y' => round($bottom - ($day['count'] / $peak) * ($bottom - $top), 2),
                    ...$day,
                ]);

                $line = $points->map(fn (array $p) => "{$p['x']},{$p['y']}")->implode(' ');
                $area = "{$left},{$bottom} {$line} {$right},{$bottom}";
            @endphp

            <div class="relative p-5" data-chart>
                <svg viewBox="0 0 600 200" class="h-56 w-full" role="img"
                    aria-label="Daily message volume for the last 30 days. Peak of {{ $peak }} messages.">
                    <defs>
                        <linearGradient id="chart-fill" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#2563eb" stop-opacity="0.18" />
                            <stop offset="100%" stop-color="#2563eb" stop-opacity="0" />
                        </linearGradient>
                    </defs>

                    {{-- Recessive grid --}}
                    @foreach ([0.25, 0.5, 0.75] as $fraction)
                        <line x1="{{ $left }}" x2="{{ $right }}" y1="{{ $bottom - $fraction * ($bottom - $top) }}"
                            y2="{{ $bottom - $fraction * ($bottom - $top) }}" stroke="#e2e8f0" stroke-width="1" />
                    @endforeach
                    <line x1="{{ $left }}" x2="{{ $right }}" y1="{{ $bottom }}" y2="{{ $bottom }}" stroke="#cbd5e1" stroke-width="1" />

                    <polygon points="{{ $area }}" fill="url(#chart-fill)" />
                    <polyline points="{{ $line }}" fill="none" stroke="#2563eb" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />

                    <line data-chart-cursor class="hidden" y1="{{ $top }}" y2="{{ $bottom }}" x1="0" x2="0"
                        stroke="#94a3b8" stroke-width="1" stroke-dasharray="3 3" />

                    {{-- Invisible hover targets, one per day --}}
                    @foreach ($points as $p)
                        <rect data-chart-hit data-x="{{ $p['x'] }}" data-label="{{ $p['label'] }}"
                            data-count="{{ $p['count'] }} {{ str('message')->plural($p['count']) }}"
                            x="{{ $p['x'] - $step / 2 }}" y="{{ $top }}" width="{{ $step }}"
                            height="{{ $bottom - $top }}" fill="transparent" />
                    @endforeach
                </svg>

                <div class="mt-1 flex justify-between px-1 text-[0.65rem] text-slate-400">
                    <span>{{ $dailyVolume[0]['label'] }}</span>
                    <span>{{ $dailyVolume[intdiv($n, 2)]['label'] }}</span>
                    <span>{{ $dailyVolume[$n - 1]['label'] }}</span>
                </div>

                <div data-chart-tooltip
                    class="pointer-events-none absolute top-4 hidden -translate-x-1/2 rounded-lg bg-navy-900 px-3 py-1.5 text-center shadow-lg">
                    <p data-chart-tooltip-label class="text-[0.65rem] font-medium text-slate-300"></p>
                    <p data-chart-tooltip-value class="text-xs font-semibold text-white"></p>
                </div>
            </div>
        </x-card>

        {{-- Status breakdown --}}
        <x-card title="Inbox by status">
            @php $statusPeak = max(1, max(array_column($statusBreakdown, 'count'))); @endphp

            <ul class="space-y-4">
                @foreach ($statusBreakdown as $row)
                    <li>
                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center gap-2 text-slate-600">
                                <span class="size-2.5 rounded-full" style="background: {{ $row['status']->chartColor() }}"></span>
                                {{ $row['status']->label() }}
                            </span>
                            <span class="font-semibold text-slate-900">{{ $row['count'] }}</span>
                        </div>
                        <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full" style="width: {{ round($row['count'] / $statusPeak * 100) }}%; background: {{ $row['status']->chartColor() }}"></div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-6 border-t border-slate-100 pt-4">
                <h3 class="text-xs font-semibold uppercase tracking-wide text-slate-400">Top requested services</h3>
                @if ($serviceBreakdown->isEmpty())
                    <p class="mt-3 text-sm text-slate-500">No service-linked enquiries in the last 90 days.</p>
                @else
                    @php $servicePeak = max(1, $serviceBreakdown->max('total')); @endphp
                    <ul class="mt-3 space-y-3">
                        @foreach ($serviceBreakdown->take(5) as $row)
                            <li>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="truncate text-slate-600">{{ $row->name }}</span>
                                    <span class="font-semibold text-slate-900">{{ $row->total }}</span>
                                </div>
                                <div class="mt-1 h-1.5 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-brand-600" style="width: {{ round($row->total / $servicePeak * 100) }}%"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Recent messages --}}
        <x-card title="Recent messages" class="lg:col-span-2" :padding="false">
            <x-slot:action>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">
                    View all
                </a>
            </x-slot:action>

            @if ($recentMessages->isEmpty())
                <x-empty-state title="No messages yet">
                    New enquiries from the website will appear here.
                </x-empty-state>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentMessages as $recent)
                        <li>
                            <a href="{{ route('admin.messages.show', $recent) }}"
                                class="flex items-center gap-4 px-5 py-3.5 transition-colors hover:bg-slate-50">
                                <x-avatar :name="$recent->name" />
                                <div class="min-w-0 flex-1">
                                    <p class="flex items-center gap-2 text-sm {{ $recent->isUnread() ? 'font-semibold text-slate-900' : 'font-medium text-slate-700' }}">
                                        {{ $recent->name }}
                                        @if ($recent->isUnread())
                                            <span class="size-1.5 rounded-full bg-brand-600" title="Unread"></span>
                                        @endif
                                    </p>
                                    <p class="truncate text-sm text-slate-500">{{ $recent->subject }}</p>
                                </div>
                                <div class="hidden shrink-0 flex-col items-end gap-1 sm:flex">
                                    <x-status-badge :status="$recent->status" />
                                    <span class="text-xs text-slate-400">{{ $recent->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-card>

        {{-- Needs attention --}}
        <x-card title="Needs attention" :padding="false">
            @if ($urgentMessages->isEmpty())
                <x-empty-state icon="check" title="All clear">
                    No high-priority messages are waiting for a reply.
                </x-empty-state>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($urgentMessages as $urgent)
                        <li>
                            <a href="{{ route('admin.messages.show', $urgent) }}"
                                class="flex flex-col gap-1.5 px-5 py-3.5 transition-colors hover:bg-slate-50">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="truncate text-sm font-medium text-slate-900">{{ $urgent->name }}</p>
                                    <x-priority-badge :priority="$urgent->priority" />
                                </div>
                                <p class="truncate text-sm text-slate-500">{{ $urgent->subject }}</p>
                                <p class="text-xs text-slate-400">
                                    {{ $urgent->service?->name ?? 'General enquiry' }} · {{ $urgent->created_at->diffForHumans() }}
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-card>
    </div>
</x-layouts.admin>
