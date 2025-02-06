<!DOCTYPE html>
<html>
<head>
    <title>New Leave Request</title>
</head>
<body>
@php
    use Carbon\Carbon;
    $formattedStartDate = Carbon::parse($leaveRequest->start_date)->format('F j, Y');
    $formattedEndDate = $leaveRequest->end_date ? Carbon::parse($leaveRequest->end_date)->format('F j, Y') : null;
@endphp
    <h2>New Leave Request Assigned to You</h2>
    <h3>{{ $leaveRequest->user->first_name }} {{ $leaveRequest->user->last_name }}</h3>
    @if ($leaveRequest->end_date == null)
    <h3>{{ $formattedStartDate }}</h3>
    @else
    <h3>{{ $formattedStartDate }} to {{ $formattedEndDate }}</h3>
    @endif
    <h3>{{ $leaveRequest->leaveType->name }}</h3>
        <a href="{{ url('http://starter.test/admin/leave_request/' . $leaveRequest->id . '/confirmation') }}" target="_blank">
            Open Leave Request Confirmation Page
        </a>
</body>
</html>