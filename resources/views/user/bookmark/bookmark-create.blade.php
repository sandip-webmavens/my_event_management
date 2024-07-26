<x-heading-component />

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($bookmark) ? 'Edit Bookmark' : 'Create Bookmark' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($bookmark) ? 'Edit Bookmark' : 'Create Bookmark' }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ isset($bookmark) ? route('user.bookmark.update', $bookmark->id) : route('user.bookmark.store') }}"
                method="POST">
                @csrf
                @if (isset($bookmark))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="event_id">Event</label>
                    <select class="form-control" id="event_id" name="event_id" required>
                        <option value="">Select Event</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}"
                                {{ old('event_id', isset($bookmark) ? $bookmark->event_id : '') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="review" class="form-label">Review</label>
                    <textarea name="review" id="review" class="form-control">{{ old('review', isset($bookmark) ? $bookmark->review : '') }}</textarea>
                </div>

                <button type="submit"
                    class="btn btn-primary">{{ isset($bookmark) ? 'Update Bookmark' : 'Create Bookmark' }}</button>
            </form>
        </div>
    </section>
</div>

<x-footer-component />
