<?php

namespace App\Enums;

enum PlanRequestStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Converted = 'converted';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Contacted => 'Contacted',
            self::Converted => 'Converted',
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
            self::Contacted => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            self::Converted => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
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
            self::Contacted => '#d97706',
            self::Converted => '#059669',
            self::Closed => '#8b5cf6',
        };
    }
}
