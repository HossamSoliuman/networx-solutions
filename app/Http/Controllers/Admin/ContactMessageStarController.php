<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactActivityType;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageStarController extends Controller
{
    /**
     * Toggle the starred flag.
     */
    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $message->update(['is_starred' => ! $message->is_starred]);

        $message->recordActivity(
            $message->is_starred ? ContactActivityType::Starred : ContactActivityType::Unstarred,
            $request->user(),
        );

        return back()->with('success', $message->is_starred ? 'Message starred.' : 'Star removed.');
    }
}
