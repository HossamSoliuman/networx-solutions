<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Render the admin dashboard.
     */
    public function __invoke(Request $request): View
    {
        $now = Carbon::now();

        $totalMessages = ContactMessage::query()->count();
        $unreadCount = ContactMessage::query()->inbox()->unread()->count();

        $awaitingReply = ContactMessage::query()
            ->inbox()
            ->whereIn('status', [ContactMessageStatus::New, ContactMessageStatus::Read, ContactMessageStatus::InProgress])
            ->count();

        $repliedThisMonth = ContactMessage::query()
            ->whereNotNull('replied_at')
            ->where('replied_at', '>=', $now->copy()->startOfMonth())
            ->count();

        $thisWeek = ContactMessage::query()->where('created_at', '>=', $now->copy()->subDays(7))->count();
        $previousWeek = ContactMessage::query()
            ->whereBetween('created_at', [$now->copy()->subDays(14), $now->copy()->subDays(7)])
            ->count();

        return view('admin.dashboard', [
            'totalMessages' => $totalMessages,
            'unreadCount' => $unreadCount,
            'awaitingReply' => $awaitingReply,
            'repliedThisMonth' => $repliedThisMonth,
            'thisWeek' => $thisWeek,
            'previousWeek' => $previousWeek,
            'avgResponseHours' => $this->averageFirstResponseHours(),
            'dailyVolume' => $this->dailyVolume(30),
            'statusBreakdown' => $this->statusBreakdown(),
            'serviceBreakdown' => $this->serviceBreakdown(),
            'recentMessages' => ContactMessage::query()
                ->inbox()
                ->with(['service', 'assignedTo'])
                ->latest()
                ->limit(6)
                ->get(),
            'urgentMessages' => ContactMessage::query()
                ->inbox()
                ->whereIn('status', [ContactMessageStatus::New, ContactMessageStatus::Read, ContactMessageStatus::InProgress])
                ->whereIn('priority', ['high', 'urgent'])
                ->with('service')
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }

    /**
     * Average hours between a message arriving and its first reply, over the last 90 days.
     */
    private function averageFirstResponseHours(): ?float
    {
        $pairs = ContactMessage::query()
            ->whereNotNull('replied_at')
            ->where('created_at', '>=', Carbon::now()->subDays(90))
            ->get(['created_at', 'replied_at']);

        if ($pairs->isEmpty()) {
            return null;
        }

        $totalMinutes = $pairs->sum(
            fn (ContactMessage $message): float => $message->created_at->diffInMinutes($message->replied_at)
        );

        return round($totalMinutes / $pairs->count() / 60, 1);
    }

    /**
     * Messages per day for the chart, zero-filled for empty days.
     *
     * @return array<int, array{date: string, label: string, count: int}>
     */
    private function dailyVolume(int $days): array
    {
        $start = Carbon::today()->subDays($days - 1);

        $counts = ContactMessage::query()
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->pluck(DB::raw('count(*) as total'), DB::raw('date(created_at) as day'))
            ->all();

        return collect(range(0, $days - 1))
            ->map(function (int $offset) use ($start, $counts): array {
                $date = $start->copy()->addDays($offset);

                return [
                    'date' => $date->toDateString(),
                    'label' => $date->format('M j'),
                    'count' => (int) ($counts[$date->toDateString()] ?? 0),
                ];
            })
            ->all();
    }

    /**
     * @return array<int, array{status: ContactMessageStatus, count: int}>
     */
    private function statusBreakdown(): array
    {
        $counts = ContactMessage::query()
            ->inbox()
            ->groupBy('status')
            ->pluck(DB::raw('count(*) as total'), 'status')
            ->all();

        return collect(ContactMessageStatus::cases())
            ->map(fn (ContactMessageStatus $status): array => [
                'status' => $status,
                'count' => (int) ($counts[$status->value] ?? 0),
            ])
            ->all();
    }

    /**
     * Message counts per requested service over the last 90 days.
     *
     * @return Collection<int, object{name: string, total: int}>
     */
    private function serviceBreakdown()
    {
        return ContactMessage::query()
            ->join('services', 'services.id', '=', 'contact_messages.service_id')
            ->where('contact_messages.created_at', '>=', Carbon::now()->subDays(90))
            ->groupBy('services.name')
            ->orderByDesc(DB::raw('count(*)'))
            ->select(['services.name', DB::raw('count(*) as total')])
            ->get();
    }
}
