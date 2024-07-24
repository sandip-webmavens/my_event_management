<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmarks;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookmarks = Bookmarks::with('user', 'event')->get();
        return view('admin.bookmark.bookmark-show', compact('bookmarks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $users = User::all();
        return view('admin.bookmark.bookmark-create', compact('events', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $bookmark = new Bookmarks();
        $bookmark->user_id = $request->user_id;
        $bookmark->event_id = $request->event_id;
        $bookmark->review = $request->review;
        $bookmark->save();

        return redirect()->route('bookmark.index')->with('success', 'Bookmark created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bookmark = Bookmarks::findOrFail($id);
        $events = Event::all();
        $users = User::all();
        return view('admin.bookmark.bookmark-create', compact('bookmark', 'events', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $bookmark = Bookmarks::findOrFail($id);
        $bookmark->user_id = $request->user_id;
        $bookmark->event_id = $request->event_id;
        $bookmark->review = $request->review;
        $bookmark->save();

        return redirect()->route('bookmark.index')->with('success', 'Bookmark updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookmark = Bookmarks::findOrFail($id);
        $bookmark->delete();

        return redirect()->route('bookmark.index')->with('success', 'Bookmark deleted successfully.');
    }
}
