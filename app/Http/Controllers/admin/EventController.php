<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
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
    public function store(EventRequest  $request)
    {
        $data = $request->validated();
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
    public function update(EventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);
        $data = $request->validated();
        $data['user_id'] = session()->get('id');
        $data['is_public'] = $request->has('is_public');
        $event->update($data);

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
