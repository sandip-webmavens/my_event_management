<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\AttendeeList;
use App\Models\Event;
use App\Models\Tickets;
use Illuminate\Http\Request;

class AttendeeUserController extends Controller
{
    public function index()
    {
        $userId = session()->get('id');
        $tickets = Tickets::where('user_id', $userId)->get();

        // Get unique event IDs from the tickets
        $eventIds = $tickets->pluck('event_id')->unique();

        $events = Event::whereIn('id', $eventIds)->get()->reverse();
        // dd($events);

        return view('user.attendee.attendee-list', compact('events'));
    }
    public function EventTickets($id)
    {
        // Fetch tickets for the specified event or the current user
        $tickets = Tickets::where('event_id', $id)
            ->Where('user_id', session()->get('id'))
            ->with('user')
            ->get()
            ->groupBy('user.email');

        $attendees = collect();

        // Iterate over each ticket and fetch corresponding attendees
        foreach ($tickets->flatten() as $ticket) {
            $attendees = $attendees->merge(
                AttendeeList::where('tickets_id', $ticket->id)
                    ->where(function ($query) use ($ticket) {
                        $ticketQrCodes = explode(',', $ticket->qr_code);
                        $query->where(function ($query) use ($ticketQrCodes) {
                            foreach ($ticketQrCodes as $code) {
                                $query->orWhere('qr_codes', 'LIKE', "%{$code}%");
                            }
                        });
                    })
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->user_id . '-' . $item->event_id . '-' . $item->tickets_id;
                    })
            );
        }

        // Return the view with the collected tickets and attendees
        return view('user.attendee.attendee-event-ticket', compact('tickets', 'attendees'));
    }


    public function store(Request $request)
{
    $qrCodes = $request->input('qr_codes', []);
    $removedQrCodes = $request->input('removed_qr_codes', []);

    foreach ($qrCodes as $ticketId => $codes) {
        $ticket = Tickets::find($ticketId);
        if ($ticket) {
            foreach ($codes as $qrCode) {
                $attendee = AttendeeList::where([
                    ['user_id', $ticket->user_id],
                    ['event_id', $ticket->event_id],
                    ['tickets_id', $ticket->id],
                ])->first();

                if ($attendee) {
                    $existingCodes = explode(',', $attendee->qr_codes);
                    if (!in_array($qrCode, $existingCodes)) {
                        $existingCodes[] = $qrCode;
                        $attendee->qr_codes = implode(',', $existingCodes);
                        $attendee->save();
                    }
                } else {
                    AttendeeList::create([
                        'user_id' => $ticket->user_id,
                        'event_id' => $ticket->event_id,
                        'tickets_id' => $ticket->id,
                        'qr_codes' => $qrCode,
                        'status' => 'p'
                    ]);
                }
            }
        }
    }

    foreach ($removedQrCodes as $ticketId => $codes) {
        if (is_array($codes)) {
            $codes = implode(',', $codes);
        }

        $codes = explode(',', $codes);
        $ticket = Tickets::find($ticketId);

        if ($ticket) {
            foreach ($codes as $qrCode) {
                $attendee = AttendeeList::where([
                    ['user_id', $ticket->user_id],
                    ['event_id', $ticket->event_id],
                    ['tickets_id', $ticketId],
                ])->first();

                if ($attendee) {
                    $existingCodes = explode(',', $attendee->qr_codes);
                    if (($key = array_search($qrCode, $existingCodes)) !== false) {
                        unset($existingCodes[$key]);
                        $attendee->qr_codes = implode(',', $existingCodes);
                        $attendee->save();
                    }
                }
            }
        }
    }

    return redirect()->route('user.attendee.index')->with('success', 'Attendees updated successfully.');
}

}
