<?php

namespace App\Enums;

enum ContactActivityType: string
{
    case Viewed = 'viewed';
    case StatusChanged = 'status_changed';
    case PriorityChanged = 'priority_changed';
    case Replied = 'replied';
    case Starred = 'starred';
    case Unstarred = 'unstarred';
    case Assigned = 'assigned';
    case Archived = 'archived';
    case Restored = 'restored';

    public function label(): string
    {
        return match ($this) {
            self::Viewed => 'First opened',
            self::StatusChanged => 'Status changed',
            self::PriorityChanged => 'Priority changed',
            self::Replied => 'Reply sent',
            self::Starred => 'Starred',
            self::Unstarred => 'Star removed',
            self::Assigned => 'Assignment changed',
            self::Archived => 'Archived',
            self::Restored => 'Restored from archive',
        };
    }

    /**
     * Tailwind classes for the timeline dot.
     */
    public function dotClasses(): string
    {
        return match ($this) {
            self::Replied => 'bg-brand-500',
            default => 'bg-slate-300',
        };
    }
}
