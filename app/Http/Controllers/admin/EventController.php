<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Organization;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $events = Event::with('eventCategory', 'organization')->get();
        return view('admin.event.event-show', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = EventCategory::all();
        $organizations = Organization::all();
        return view('admin.event.event-create', compact('categories', 'organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'category_id' => 'nullable|exists:event_categories,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'ticket_price' => 'nullable|numeric',
            'total_ticket' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['user_id'] = session()->get('id');
        $data['is_public'] = $request->has('is_public');
        $data['total_ticket'] = $request->total_ticket;
        Event::create($data);
        return redirect()->route('event.index')->with('success', 'Event created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::find($id);
        $categories = EventCategory::all();
        $organizations = Organization::all();
        return view('admin.event.event-create' , compact('event' , 'categories', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'category_id' => 'nullable|exists:event_categories,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'ticket_price' => 'nullable|numeric',
            'total_ticket' => 'nullable|integer',
        ]);

        $event = Event::findOrFail($id);

        $event->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'location' => $request->input('location'),
            'category_id' => $request->input('category_id'),
            'organization_id' => $request->input('organization_id'),
            'ticket_price' => $request->input('ticket_price'),
            'total_ticket' => $request->input('total_ticket'),
            'is_public' => $request->has('is_public'),
            'user_id' => session()->get('id'),
        ]);

        return redirect()->route('event.index')->with('success', 'Event updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Event deleted successfully.');

    }
}
