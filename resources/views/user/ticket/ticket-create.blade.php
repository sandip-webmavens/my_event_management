<x-user.heading-component />
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($ticket) ? 'Edit Ticket' : 'Create Ticket' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($ticket) ? 'Edit Ticket' : 'Create Ticket' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ isset($ticket) ? route('user.ticket.update', $ticket->id) : route('user.ticket.store') }}" method="POST">
                @csrf
                @if(isset($ticket))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="event_id">Event</label>
                    <select class="form-control" id="event_id" name="event_id" required>
                        <option value="">Select Event</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', isset($ticket) ? $ticket->event_id : '') == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', isset($ticket) ? $ticket->quantity : '') }}" required>
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_paid" name="is_paid" {{ old('is_paid', isset($ticket) ? $ticket->is_paid : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_paid">Paid</label>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" {{ old('status', isset($ticket) ? $ticket->status : 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', isset($ticket) ? $ticket->status : 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($ticket) ? 'Update Ticket' : 'Create Ticket' }}</button>
            </form>
        </div>
    </section>
</div>
<x-user.footer-component />
