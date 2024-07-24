<x-heading-component />
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User View All Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="section-heading mt-4">
                <h3>Organizations</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="organizationTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0; @endphp
                                @foreach ($organizations as $organization)
                                    @if ($user->id == $organization->user_id)
                                        @php $index++; @endphp
                                        <tr>
                                            <th scope="row">{{ $index }}</th>
                                            <td>{{ $organization->user ? $organization->user->name : '' }}</td>
                                            <td>{{ $organization->name }}</td>
                                            <td>{{ $organization->description }}</td>
                                            <td>{{ $organization->address }}</td>
                                            <td>{{ $organization->phone }}</td>
                                            <td>
                                                <a href="{{ route('organization.edit', $organization) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('organization.destroy', $organization) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="section-heading mt-4">
                <h3>Events</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="eventTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Location</th>
                                    <th>Category</th>
                                    <th>Organization</th>
                                    <th>User</th>
                                    <th>Ticket Price</th>
                                    <th>Total Tickets</th>
                                    <th>Public</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0; @endphp
                                @foreach ($events as $event)
                                    @if ($user->id == $event->user_id)
                                        @php $index++; @endphp
                                        <tr>
                                            <th scope="row">{{ $index }}</th>
                                            <td>{{ $event->title }}</td>
                                            <td>{{ $event->description }}</td>
                                            <td>{{ $event->start_date }}</td>
                                            <td>{{ $event->end_date }}</td>
                                            <td>{{ $event->location }}</td>
                                            <td>{{ $event->eventcategory->name ?? 'N/A' }}</td>
                                            <td>{{ $event->organization->name ?? 'N/A' }}</td>
                                            <td>{{ $event->user->name ?? 'N/A' }}</td>
                                            <td>{{ $event->ticket_price }}</td>
                                            <td>{{ $event->total_ticket }}</td>
                                            <td>{{ $event->is_public ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('event.edit', $event->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('event.destroy', $event->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="section-heading mt-4">
                <h3>Tickets</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="ticketTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Quantity</th>
                                    <th>Is Paid</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0; @endphp
                                @foreach ($tickets as $ticket)
                                    @if ($user->id == $ticket->user_id)
                                        @php $index++; @endphp
                                        <tr>
                                            <th scope="row">{{ $index }}</th>
                                            <td>{{ $ticket->user->name }}</td>
                                            <td>{{ $ticket->event->title }}</td>
                                            <td>{{ $ticket->quantity }}</td>
                                            <td>{{ $ticket->is_paid ? 'Yes' : 'No' }}</td>
                                            <td>{{ ucfirst($ticket->status) }}</td>
                                            <td>
                                                <a href="{{ route('ticket.edit', $ticket->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="section-heading mt-4">
                <h3>Bookmarks</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="bookmarkTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Event</th>
                                    <th>Review</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0; @endphp
                                @foreach ($bookmarks as $bookmark)
                                    @if ($user->id == $bookmark->user_id)
                                        @php $index++; @endphp
                                        <tr>
                                            <th scope="row">{{ $index }}</th>
                                            <td>{{ $bookmark->user->name }}</td>
                                            <td>{{ $bookmark->event->title }}</td>
                                            <td>{{ $bookmark->review }}</td>
                                            <td>
                                                <a href="{{ route('bookmark.edit', $bookmark->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('bookmark.destroy', $bookmark->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="section-heading mt-4">
                <h3>Attendee</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('attendee.store') }}" method="POST">
                        @csrf
                        <table id="table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Email</th>
                                    <th>Ticket QR Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0; @endphp
                                @foreach ($attendeetickets as $userEmail => $userTickets)
                                @php $index++; @endphp
                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td>{{ $userEmail }}</td>
                                    <td>
                                        @foreach ($userTickets as $ticket)
                                            @if ($ticket && $ticket->qr_code)
                                                @foreach (explode(',', $ticket->qr_code) as $qrCode)
                                                    <div>
                                                        @php
                                                            $key = $ticket->user_id . '-' . $ticket->event_id . '-' . $ticket->id;
                                                            $isChecked = isset($attendees[$key]) && in_array($qrCode, explode(',', $attendees[$key]->qr_codes));
                                                        @endphp
                                                        <input type="checkbox" name="qr_codes[{{ $ticket->id }}][]"
                                                            value="{{ $qrCode }}"
                                                            {{ $isChecked ? 'checked' : '' }}
                                                            onchange="handleCheckboxChange(this, '{{ $qrCode }}', '{{ $ticket->id }}')">
                                                        {{ $qrCode }}
                                                    </div>
                                                @endforeach
                                                <input type="hidden" id="removed_qr_codes_{{ $ticket->id }}" name="removed_qr_codes[{{ $ticket->id }}][]">
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <x-footer-component />
    <script>
        $(document).ready(function() {
            $('#organizationTable').DataTable();
            $('#eventTable').DataTable();
            $('#ticketTable').DataTable();
            $('#bookmarkTable').DataTable();
            $('#attendeeTable').DataTable();
        });
    </script>
</div>
