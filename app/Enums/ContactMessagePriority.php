<?php

namespace App\Enums;

enum ContactMessagePriority: string
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low',
            self::Normal => 'Normal',
            self::High => 'High',
            self::Urgent => 'Urgent',
        };
    }

    /**
     * Tailwind classes for the priority badge.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Low => 'bg-slate-100 text-slate-600 ring-slate-500/20',
            self::Normal => 'bg-sky-50 text-sky-700 ring-sky-600/20',
            self::High => 'bg-orange-50 text-orange-700 ring-orange-600/20',
            self::Urgent => 'bg-red-50 text-red-700 ring-red-600/20',
        };
    }

    public function sortWeight(): int
    {
        return match ($this) {
            self::Urgent => 4,
            self::High => 3,
            self::Normal => 2,
            self::Low => 1,
        };
    }
}
