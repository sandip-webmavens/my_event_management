<x-heading-component />

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
                            <li class="breadcrumb-item active">event list</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <table id="table" class="table  table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Event</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp
                            <tr>
                                @foreach ($events as $event)
                                @php $index++; @endphp
                                    <th scope="row">{{ $index }}</th>
                                    <td>{{ $event->title }}</td>
                                    <td>
                                        <a href="{{ route('attendee.show.ticket', $event->id) }}" class="btn btn-warning">attendee</a>
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

<x-footer-component />

<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
