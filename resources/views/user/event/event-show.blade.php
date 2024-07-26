<x-user.heading-component title="Event" subtitle="Dashboard" />

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">event list</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('user.event.create') }}">
                    <button class="btn btn-primary">Create event</button>
                </a>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="table" class="table table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Location</th>
                                <th scope="col">Category</th>
                                <th scope="col">Organization</th>
                                <th scope="col">Ticket Price</th>
                                <th scope="col">Total Tickets</th>
                                <th scope="col">Public</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp
                            @foreach ($events as $event)
                                @php $index++;
                                    @endphp
                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->description }}</td>
                                    <td>{{ $event->start_date }}</td>
                                    <td>{{ $event->end_date }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>{{ $event->eventcategory->name ?? 'N/A' }}</td>
                                    <td>{{ $event->organization->name ?? 'N/A' }}</td>
                                    <td>{{ $event->ticket_price }}</td>
                                    <td>{{ $event->total_ticket }}</td>
                                    <td>{{ $event->is_public ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('user.event.edit', $event->id) }}">
                                            <button class="btn btn-warning">Edit</button>
                                        </a>
                                        <form action="{{ route('user.event.destroy', $event->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<x-user.footer-component />

<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
