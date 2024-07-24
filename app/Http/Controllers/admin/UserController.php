<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendeeList;
use App\Models\Bookmarks;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserShow()
    {
        $users = User::with('role')->get();
        return view('admin.user.user-show', compact('users'));
    }

    public function UserCreate()
    {
        return view('admin.user.user-create');
    }

    public function UserStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = new User();
        $user->role_id = 2;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            if ($request->hasFile('image')) {
                $user->addMediaFromRequest('image')
                    ->withResponsiveImages()
                    ->toMediaCollection('image');
            }
        }

        return redirect()->route('user.show')->with('success', 'User created successfully.');
    }

    public function UserView($id)
    {
        $user = User::findOrFail($id);
        $organizations = Organization::where('user_id', $id)->get();
        $events = Event::where('user_id', $id)->get();
        $tickets = Tickets::where('user_id', $id)->get();
        $bookmarks = Bookmarks::where('user_id', $id)->get();

        // Get attendeetickets and attendees
        list($attendeetickets, $attendees) = $this->EventTickets($id);

        return view('admin.user.user-view', compact('user', 'organizations', 'events', 'tickets', 'bookmarks', 'attendeetickets', 'attendees'));
    }

    public function EventTickets($id)
    {
        $attendeetickets = Tickets::where('user_id', $id)->with('user')->get()->groupBy('user.email');

        $attendees = collect();

        foreach ($attendeetickets->flatten() as $ticket) {
            if (!$ticket) {
                continue;
            }

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

        return [$attendeetickets, $attendees];
    }

    public function UserEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.user-edit', compact('user'));
    }

    public function UserEditStore(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->role_id = 2;
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {
            if ($request->hasFile('image')) {
                $user->clearMediaCollection('image');
                $user->addMediaFromRequest('image')
                    ->withResponsiveImages()
                    ->toMediaCollection('image');
            }
        }

        return redirect()->route('user.show')->with('success', 'User updated successfully.');
    }

    public function UserDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.show')->with('success', 'User deleted successfully.');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        session()->flush();
        return redirect()->route('user.login')->with('success', 'Logged out successfully.');
    }
}
