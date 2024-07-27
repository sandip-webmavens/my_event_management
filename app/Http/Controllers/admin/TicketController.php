<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketsValidation;
use App\Models\Event;
use App\Models\Tickets;
use App\Models\User;
use App\Models\TicketPayment;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Tickets::with('user', 'event')->get();
        return view('admin.ticket.ticket-show', compact('tickets'));
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
        return view('admin.ticket.ticket-create', compact('users', 'events'));
    }

    public function store(TicketsValidation $request)
    {
        $data = $request->validated();
        $data['is_paid'] = $request->has('is_paid') ? 1 : 0;

        $event = Event::findOrFail($data['event_id']);
        $ticketPrice = $event->ticket_price;

        $data['qr_code'] = $this->generateBarcodes($request->quantity);

        $ticket = Tickets::create($data);

        if ($ticket->is_paid) {
            $this->createPaymentRecord($ticket, $ticketPrice);
        }

        return redirect()->route('ticket.index')->with('success', 'Ticket created successfully.');
    }

    public function show(string $id)
    {
        $ticket = Tickets::with('user', 'event')->findOrFail($id);
        return view('admin.ticket.ticket-show-single', compact('ticket'));
    }

    public function edit(string $id)
    {
        $ticket = Tickets::findOrFail($id);
        $users = User::all();
        $events = Event::all();
        return view('admin.ticket.ticket-create', compact('ticket', 'users', 'events'));
    }

    public function update(TicketsValidation $request, string $id)
    {
        $ticket = Tickets::findOrFail($id);
        $data = $request->validated();
        $data['is_paid'] = $request->has('is_paid') ? 1 : 0;

        $event = Event::findOrFail($data['event_id']);
        $ticketPrice = $event->ticket_price;

        $data['qr_code'] = $this->generateBarcodes($request->quantity);

        $ticket->update($data);

        if ($ticket->is_paid) {
            $this->createPaymentRecord($ticket, $ticketPrice);
        }

        return redirect()->route('ticket.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(string $id)
    {
        $ticket = Tickets::findOrFail($id);
        $ticket->delete();
        return redirect()->route('ticket.index')->with('success', 'Ticket deleted successfully.');
    }

    private function generateBarcodes($quantity)
    {
        $barcodes = [];
        for ($i = 0; $i < $quantity; $i++) {
            $barcodes[] = $this->generateRandomString();
        }
        return implode(',', $barcodes);
    }

    private function generateRandomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function createPaymentRecord($ticket, $ticketPrice)
    {
        $amount = $ticketPrice * $ticket->quantity;
        TicketPayment::updateOrCreate(['ticket_id' => $ticket->id,], [
            'amount' => $amount,
            'payment_method' => 'Manual', // Adjust this based on actual payment method
            'transaction_id' => $this->generateRandomString(10), // Placeholder transaction ID
            'paid_at' => now(),
        ]);
    }
}


 // TicketPayment::updateOrCreate(['ticket_id' => $ticket->id,], [
        //     'amount' => $amount,
        //     'payment_method' => 'Manual',
        //     'transaction_id' => $this->generateRandomString(10),
        //     'paid_at' => now(),
        // ]);
