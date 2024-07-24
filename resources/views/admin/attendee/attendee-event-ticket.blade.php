<x-heading-component />

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">event ticket attendance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">event ticket attendance</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('attendee.store') }}" method="POST">
                        @csrf
                        <table id="table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Email</th>
                                    <th>Ticket QR Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0; @endphp
                                @foreach ($tickets as $userEmail => $userTickets)
                                    @php $index++; @endphp
                                    <tr>
                                        <th scope="row">{{ $index }}</th>
                                        <td>{{ $userEmail }}</td>
                                        <td>
                                            @foreach ($userTickets as $ticket)
                                                @foreach (explode(',', $ticket->qr_code) as $qrCode)
                                                    <div>
                                                        @php
                                                            $key = $ticket->user_id . '-' . $ticket->event_id . '-' . $ticket->id;
                                                            $isChecked = isset($attendees[$key]) && in_array($qrCode, explode(',', $attendees[$key]->qr_codes));
                                                        @endphp
                                                        <input type="checkbox" name="qr_codes[{{ $ticket->id }}][]"
                                                            value="{{ $qrCode }}"
                                                            {{ $isChecked ? 'checked' : '' }}
                                                            onchange="handleCheckboxChange(this, '{{ $qrCode }}', '{{ $ticket->id }}')">
                                                        {{ $qrCode }}
                                                    </div>
                                                @endforeach
                                                <input type="hidden" id="removed_qr_codes_{{ $ticket->id }}" name="removed_qr_codes[{{ $ticket->id }}][]">
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<x-footer-component />

<script>
    function handleCheckboxChange(checkbox, qrCode, ticketId) {
        const removedQrCodesField = document.getElementById(`removed_qr_codes_${ticketId}`);
        let removedQrCodes = removedQrCodesField.value ? removedQrCodesField.value.split(',') : [];

        if (checkbox.checked) {
            const index = removedQrCodes.indexOf(qrCode);
            if (index > -1) {
                removedQrCodes.splice(index, 1);
            }
        } else {
            if (!removedQrCodes.includes(qrCode)) {
                removedQrCodes.push(qrCode);
            }
        }

        removedQrCodesField.value = removedQrCodes.join(',');
    }

    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
