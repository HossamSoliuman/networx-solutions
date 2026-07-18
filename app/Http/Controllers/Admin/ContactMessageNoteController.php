<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactActivityType;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageNoteController extends Controller
{
    /**
     * Attach an internal note (never emailed to the sender).
     */
    public function store(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $message->notes()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        $message->recordActivity(ContactActivityType::NoteAdded, $request->user());

        return back()->with('success', 'Internal note added.');
    }
}
