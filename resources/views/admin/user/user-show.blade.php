<x-heading-component />
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User</h1>
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
                <a href="{{ route('user.create') }}">
                    <button class="btn btn-primary">Create User</button>
                </a>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp
                            @foreach ($users as $user)
                                @php $index++; @endphp
                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td>
                                        @if ($user->getFirstMediaUrl('image'))
                                            <img src="{{ asset($user->getFirstMediaUrl('image', 'thumb')) }}"
                                                alt="User Image" width="100">
                                        @else
                                            No image
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ? $user->role->name : 'Uncategorized' }}</td>
                                    <td>
                                        <a href="{{ route('user.view', ['id' => $user->id]) }}">
                                            <button class="btn btn-primary">view</button>
                                        </a>
                                        <a href="{{ route('user.edit', ['id' => $user->id]) }}">
                                            <button class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="{{ route('user.delete', ['id' => $user->id]) }}">
                                            <button class="btn btn-danger">Delete</button>
                                        </a>
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
       $('#table').DataTable({
           "initComplete": function(settings, json) {
               // Remove any existing filter rows
               $('.gtp-dt-filter-row').remove();

               // Construct the new filter row
               var theadSecondRow = '<tr class="gtp-dt-filter-row">';
               $(this).find('thead tr th').each(function(index) {
                   theadSecondRow += '<td class="gtp-dt-select-filter-' + index + '"></td>';
               });
               theadSecondRow += '</tr>';

               // Insert the new filter row after the heading
               var ShowFilterBox = 'afterHeading'; // Change to 'beforeHeading' if needed
               if (ShowFilterBox === 'beforeHeading') {
                   $(this.api().table().header()).before(theadSecondRow);
               } else {
                   $(theadSecondRow).insertAfter($(this).find('thead tr'));
               }

               // Apply filter inputs to columns
               this.api().columns().every(function(index) {
                   var column = this;
                   var filterCell = $(`.gtp-dt-select-filter-${index}`);

                   // Apply filter inputs only to specific columns
                   if (index == 2 || index == 3) {
                       filterCell.html('<input type="text" class="gtp-dt-input-filter" placeholder="Search">');
                       filterCell.find('input.gtp-dt-input-filter').on('keyup change', function() {
                           if (column.search() !== this.value) {
                               column.search(this.value).draw();
                           }
                       });
                   } else if (index === 4) {
                       var select = $('<select><option value=""></option></select>')
                           .appendTo(filterCell)
                           .on('change', function() {
                               var val = $.fn.dataTable.util.escapeRegex($(this).val());
                               column.search(val ? '^' + val + '$' : '', true, false).draw();
                           });

                       column.data().unique().sort().each(function(d, j) {
                           select.append('<option value="' + d + '">' + d + '</option>');
                       });
                   }
               });
           }
       });
   }
   </script>
