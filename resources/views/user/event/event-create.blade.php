<x-user.heading-component title="Event" subtitle="Dashboard" />

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Event Create Form</h1>
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
                    <form action="{{ isset($event) ? route('user.event.update', $event->id) : route('user.event.store') }}" method="POST">
                        @csrf
                        @if(isset($event))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="title">Event Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', isset($event) ? $event->title : '') }}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', isset($event) ? $event->description : '') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', isset($event) ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required>
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', isset($event) ? $event->end_date->format('Y-m-d\TH:i') : '') }}" required>
                            @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', isset($event) ? $event->location : '') }}" required>
                            @error('location')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="map" style="height: 400px; width: 100%;"></div>
                        <div id="map-error" style="display: none; color: red; font-weight: bold; text-align: center;">Failed to load Google Maps.</div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', isset($event) ? $event->category_id : '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="organization_id">Organization</label>
                            <select class="form-control" id="organization_id" name="organization_id">
                                <option value="">Select Organization</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ old('organization_id', isset($event) ? $event->organization_id : '') == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ticket_price">Ticket Price</label>
                            <input type="number" class="form-control" id="ticket_price" name="ticket_price" value="{{ old('ticket_price', isset($event) ? $event->ticket_price : '') }}">
                            @error('ticket_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="total_ticket">Total Tickets</label>
                            <input type="number" class="form-control" id="total_ticket" name="total_ticket" value="{{ old('total_ticket', isset($event) ? $event->total_ticket : '') }}">
                            @error('total_ticket')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_public" name="is_public" {{ old('is_public', isset($event) ? $event->is_public : true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">Public</label>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ isset($event) ? 'Update' : 'Create' }}</button>
                    </form>
                </div>
            </section>
        </div>

        <x-user.footer-component />
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBluhGPTyMs3uE4OneqolrgJa5Cz0x-yu8&callback=initMap" async defer></script>
    <script>
        let map;
        let marker;
        let geocoder;

        function initMap() {
            geocoder = new google.maps.Geocoder();
            const initialLocation = { lat: 22.6708, lng: 71.5724 }; // Default location
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 8,
                center: initialLocation,
            });
            marker = new google.maps.Marker({
                map,
                position: initialLocation,
            });

            // Handle address input
            const locationInput = document.getElementById('location').value;
            // console.log(locationInput);
            if (locationInput) {
                geocodeAddress(locationInput);
            }

            // Add event listener to location input
            document.getElementById('location').addEventListener('change', () => {
                const address = document.getElementById('location').value;
                geocodeAddress(address);
            });
        }

        function geocodeAddress(address) {
            geocoder.geocode({ address: address }, (results, status) => {
                if (status === "OK") {
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    map.setZoom(15); // Zoom in to the location
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }

        // Handle API load failure
        window.addEventListener('error', function(event) {
            if (event.message.includes('Google Maps JavaScript API')) {
                document.getElementById('map-error').style.display = 'block'; // Show error message if API fails
            }
        });
    </script>
<x-user.footer-component />
