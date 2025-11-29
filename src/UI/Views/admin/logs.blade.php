@extends('dhl::layout')

@section('content')
<h3>DHL Logs</h3>

<table class="dhl-table">
    <thead>
    <tr>
        <th>Event</th>
        <th>Tracking #</th>
        <th>Payload</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->event_type }}</td>
            <td>{{ $log->tracking_number }}</td>
            <td><pre>{{ $log->payload }}</pre></td>
            <td>{{ $log->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $logs->links() }}
@endsection
