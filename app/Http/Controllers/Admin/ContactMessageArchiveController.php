<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactActivityType;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageArchiveController extends Controller
{
    /**
     * Archive the message, or restore it from the archive.
     */
    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $archiving = ! $message->isArchived();

        $message->update(['archived_at' => $archiving ? now() : null]);

        $message->recordActivity(
            $archiving ? ContactActivityType::Archived : ContactActivityType::Restored,
            $request->user(),
        );

        return back()->with('success', $archiving ? 'Message archived.' : 'Message restored.');
    }
}
