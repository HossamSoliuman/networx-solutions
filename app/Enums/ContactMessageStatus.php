<?php

namespace App\Enums;

enum ContactMessageStatus: string
{
    case New = 'new';
    case Read = 'read';
    case InProgress = 'in_progress';
    case Replied = 'replied';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Read => 'Read',
            self::InProgress => 'In Progress',
            self::Replied => 'Replied',
            self::Closed => 'Closed',
        };
    }

    /**
     * Tailwind classes for the status badge.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::New => 'bg-blue-50 text-blue-700 ring-blue-600/20',
            self::Read => 'bg-sky-50 text-sky-700 ring-sky-600/20',
            self::InProgress => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            self::Replied => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            self::Closed => 'bg-slate-100 text-slate-600 ring-slate-500/20',
        };
    }

    /**
     * Hex color used for dashboard charts.
     */
    public function chartColor(): string
    {
        return match ($this) {
            self::New => '#2563eb',
            self::Read => '#0ea5e9',
            self::InProgress => '#d97706',
            self::Replied => '#059669',
            self::Closed => '#8b5cf6',
        };
    }
}
