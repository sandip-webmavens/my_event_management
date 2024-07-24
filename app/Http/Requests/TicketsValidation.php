<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketsValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1|max:'.($this->getTotalTicketsForEvent() - $this->getTotalTicketsSoldForEvent()),
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Get total tickets available for the event.
     */
    private function getTotalTicketsForEvent(): int
    {
        return \App\Models\Event::find($this->event_id)->total_ticket;
    }

    /**
     * Get total tickets sold for the event.
     */
    private function getTotalTicketsSoldForEvent(): int
    {
        return \App\Models\Tickets::where('event_id', $this->event_id)->sum('quantity');
    }
}
