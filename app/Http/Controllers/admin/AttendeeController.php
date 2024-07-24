<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AttendeeList;
use App\Models\Event;
use App\Models\Tickets;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('admin.attendee.attendee-list', compact('events'));
    }

    public function EventTickets($id)
    {
        $tickets = Tickets::where('event_id', $id)->with('user')->get()->groupBy('user.email');

        $attendees = collect();

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

        return view('admin.attendee.attendee-event-ticket', compact('tickets', 'attendees'));
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

    return redirect()->route('attendee.index')->with('success', 'Attendees updated successfully.');
}

}
