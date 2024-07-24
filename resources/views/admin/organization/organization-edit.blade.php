<x-heading-component />
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Oraganization Edit Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('organization.update' , $organization->id) }}" method="POST">
                @method('PUT')
               @csrf
                <div class="form-group">
                    <label for="user_id">User Name</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ isset($organization) && $user->id == $organization->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $organization->name }}" placeholder="Enter name"
                        required>
                </div>
                <div class="form-group">
                    <label for="description">description </label>
                    <input type="text" class="form-control" id="description" name="description"
                        placeholder="description"  value="{{ $organization->description }}" required>
                </div>
                <div class="form-group">
                    <label for="address">address </label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $organization->address }}" placeholder="address"
                        required>
                </div>
                <div class="form-group">
                    <label for="phone">phone number </label>
                    <input type="number"  class="form-control" id="phone" name="phone" value="{{ $organization->phone }}" placeholder="phone"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
</div>
<x-footer-component />
