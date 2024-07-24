<x-heading-component />
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Organization</h1>
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
            <div class="d-flex justify-content-end">
                <a href="{{ route('organization.create') }}">
                    <button class="btn btn-primary">Create Organization</button>
                </a>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp
                             @foreach ($organizations as $organization)
                                @php $index++; @endphp
                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td>{{ $organization->user ? $organization->user->name : '' }}</td>
                                    <td>{{ $organization->name }}</td>
                                    <td>{{ $organization->description }}</td>
                                    <td>{{ $organization->address }}</td>
                                    <td>{{ $organization->phone }}</td>

                                    <td>
                                        <a href="{{ route('organization.edit', $organization) }}">
                                            <button class="btn btn-warning">Edit</button>
                                        </a>
                                        <form action="{{ route('organization.destroy', $organization) }}" method="POST" style="display:inline;">
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
<x-footer-component />
<script>
    $(document).ready(function() {
       LoadDataTable();
   });

   function LoadDataTable() {
       $('#table').DataTable();
   }
   </script>
