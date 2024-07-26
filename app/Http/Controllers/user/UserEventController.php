<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Organization;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    public function index()
    {
        $userId = session()->get('id');
        $events = Event::where('user_id', $userId)
            ->with('eventCategory', 'organization')
            ->get()
            ->reverse();

        return view('user.event.event-show', compact('events'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        $organizations = Organization::all();
        return view('user.event.event-create', compact('categories', 'organizations'));
    }

    public function store(EventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = session()->get('id');
        $data['is_public'] = $request->has('is_public');
        Event::create($data);
        return redirect()->route('user.event.index')->with('success', 'Event created successfully.');
    }

    public function show(string $id)
    {
        // Implement the show method if needed.
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $categories = EventCategory::all();
        $organizations = Organization::all();
        return view('user.event.event-create', compact('event', 'categories', 'organizations'));
    }

    public function update(EventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);
        $data = $request->validated();
        $data['user_id'] = session()->get('id');
        $data['is_public'] = $request->has('is_public');
        $event->update($data);

        return redirect()->route('user.event.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('user.event.index')->with('success', 'Event deleted successfully.');
    }
}
