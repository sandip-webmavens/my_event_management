<x-heading-component  />

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bookmarks list</h1>
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
                <a href="{{ route('bookmark.create') }}" class="btn btn-primary">Create Bookmark</a>

            </div>
            <div class="row">
                <div class="col-12">
                    <table id="table" class="table  table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>user name</th>
                                <th>Event</th>
                                <th>Review</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp
                            @foreach ($bookmarks as $bookmark)
                            @php $index++;@endphp
                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td>{{ $bookmark->user->name }}</td>
                                    <td>{{ $bookmark->event->title }}</td>
                                    <td>{{ $bookmark->review }}</td>
                                    <td>
                                        <a href="{{ route('bookmark.edit', $bookmark->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('bookmark.destroy', $bookmark->id) }}" method="POST" style="display: inline;">
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

<x-footer-component />

<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
