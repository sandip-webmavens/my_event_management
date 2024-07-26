<x-user.heading-component title="Tickets" subtitle="Dashboard" />

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ticket list</h1>
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
                <a href="{{ route('user.ticket.create') }}" class="btn btn-primary">Create Ticket</a>

            </div>
            <div class="row">
                <div class="col-12">
                    <table id="table" class="table  table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Event</th>
                                <th>Quantity</th>
                                <th>Is Paid</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp

                            @foreach($tickets as $ticket)
                            @php $index++; @endphp

                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td>{{ $ticket->event->title }}</td>
                                    <td>{{ $ticket->quantity }}</td>
                                    <td>{{ $ticket->is_paid ? 'Yes' : 'No' }}</td>
                                    <td>{{ ucfirst($ticket->status) }}</td>
                                    <td>
                                        <a href="{{ route('user.ticket.edit', $ticket->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('user.ticket.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
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
