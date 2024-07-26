<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Bookmarks;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
class BookmarkUserController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmarks::where('user_id' , session()->get('id'))->with('user', 'event')->get()->reverse();
        return view('user.bookmark.bookmark-show', compact('bookmarks'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $users = User::all();
        return view('user.bookmark.bookmark-create', compact('events', 'users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bookmark = new Bookmarks();
        $bookmark->user_id = session()->get('id');
        $bookmark->event_id = $request->event_id;
        $bookmark->review = $request->review;
        $bookmark->save();

        return redirect()->route('user.bookmark.index')->with('success', 'Bookmark created successfully.');
    }
    public function edit(string $id)
    {
        $bookmark = Bookmarks::findOrFail($id);
        $events = Event::all();
        $users = User::all();
        return view('user.bookmark.bookmark-create', compact('bookmark', 'events', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bookmark = Bookmarks::findOrFail($id);
        $bookmark->user_id = session()->get('id');
        $bookmark->event_id = $request->event_id;
        $bookmark->review = $request->review;
        $bookmark->save();
        return redirect()->route('user.bookmark.index')->with('success', 'Bookmark updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookmark = Bookmarks::findOrFail($id);
        $bookmark->delete();
        return redirect()->route('user.bookmark.index')->with('success', 'Bookmark deleted successfully.');
    }
}
