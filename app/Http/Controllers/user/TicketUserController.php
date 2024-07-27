<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketsValidation;
use App\Models\Event;
use App\Models\Tickets;
use App\Models\User;
use App\Models\TicketPayment;
use Illuminate\Http\Request;

class TicketUserController extends Controller
{
    public function index()
    {
        $tickets = Tickets::where('user_id', session()->get('id'))
                          ->with('user', 'event')
                          ->latest() // Retrieve latest tickets
                          ->get();
        return view('user.ticket.ticket-show', compact('tickets'));
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
        return view('user.ticket.ticket-create', compact('users', 'events'));
    }

    public function store(TicketsValidation $request)
    {
        $data = $request->validated();
        $data['is_paid'] = $request->has('is_paid') ? 1 : 0;
        $event = Event::findOrFail($data['event_id']);
        $data['qr_code'] = $this->generateBarcodes($request->quantity);
        $data['user_id'] = session()->get('id');

        $ticket = Tickets::create($data);

        if ($ticket->is_paid) {
            $paymentData = $this->createPaymentRecord($ticket, $event->ticket_price);
            // Handle payment logic or redirect to payment gateway
            // return redirect()->route('stripe', $paymentData)->with('success', 'Payment was successful.');
        }

        return redirect()->route('user.ticket.index')->with('success', 'Ticket created successfully.');
    }

    public function edit(string $id)
    {
        $ticket = Tickets::findOrFail($id);
        $users = User::all();
        $events = Event::all();
        return view('user.ticket.ticket-create', compact('ticket', 'users', 'events'));
    }

    public function update(TicketsValidation $request, string $id)
    {
        $ticket = Tickets::findOrFail($id);
        $data = $request->validated();
        $data['is_paid'] = $request->has('is_paid') ? 1 : 0;
        $data['user_id'] = session()->get('id');
        $event = Event::findOrFail($data['event_id']);
        $data['qr_code'] = $this->generateBarcodes($request->quantity);

        $ticket->update($data);

        if ($ticket->is_paid) {
            $paymentData = $this->createPaymentRecord($ticket, $event->ticket_price);
            // Handle payment logic or redirect to payment gateway
            return redirect()->route('stripe', $paymentData)->with('success', 'Payment was successful.');
        }

        return redirect()->route('user.ticket.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(string $id)
    {
        $ticket = Tickets::findOrFail($id);
        $ticket->delete();
        return redirect()->route('user.ticket.index')->with('success', 'Ticket deleted successfully.');
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
        $transaction_id = $this->generateRandomString(10);
        $paid_at = now();

        // Create a new TicketPayment record
        // TicketPayment::create([
        //     'amount' => $amount,
        //     'ticket_id' => $ticket->id,
        //     'payment_method' => 'stripe',
        //     'transaction_id' => $transaction_id,
        //     'paid_at' => $paid_at,
        // ]);

        return [
            'amount' => $amount,
            'ticket_id' => $ticket->id,
            'payment_method' => 'stripe',
            'transaction_id' => $transaction_id,
            'paid_at' => $paid_at
        ];
    }
}
