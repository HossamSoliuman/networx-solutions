<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactMessageExportController extends Controller
{
    /**
     * Stream the (filtered) inbox as a CSV download.
     */
    public function __invoke(Request $request): StreamedResponse
    {
        $filters = $request->only([
            'view', 'status', 'q', 'priority', 'service_id', 'assigned', 'from', 'to', 'sort',
        ]);

        $query = ContactMessage::query()
            ->filter($filters, $request->user())
            ->with(['service', 'assignedTo']);

        $filename = 'networx-messages-'.now()->format('Y-m-d-Hi').'.csv';

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Reference', 'Received', 'Name', 'Email', 'Phone', 'Company',
                'Subject', 'Service', 'Status', 'Priority', 'Assigned To',
                'Read At', 'Replied At', 'Message',
            ]);

            $query->lazy()->each(function (ContactMessage $message) use ($handle): void {
                fputcsv($handle, [
                    $message->reference,
                    $message->created_at->toDateTimeString(),
                    $message->name,
                    $message->email,
                    $message->phone,
                    $message->company,
                    $message->subject,
                    $message->service?->name,
                    $message->status->label(),
                    $message->priority->label(),
                    $message->assignedTo?->name,
                    $message->read_at?->toDateTimeString(),
                    $message->replied_at?->toDateTimeString(),
                    $message->message,
                ]);
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
