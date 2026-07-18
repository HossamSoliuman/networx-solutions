<?php

namespace App\Enums;

enum ContactActivityType: string
{
    case Viewed = 'viewed';
    case StatusChanged = 'status_changed';
    case PriorityChanged = 'priority_changed';
    case Replied = 'replied';
    case NoteAdded = 'note_added';
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
            self::NoteAdded => 'Internal note added',
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
            self::Viewed => 'bg-sky-400',
            self::StatusChanged => 'bg-amber-500',
            self::PriorityChanged => 'bg-orange-500',
            self::Replied => 'bg-emerald-500',
            self::NoteAdded => 'bg-violet-500',
            self::Starred, self::Unstarred => 'bg-yellow-400',
            self::Assigned => 'bg-cyan-500',
            self::Archived, self::Restored => 'bg-slate-400',
        };
    }
}
