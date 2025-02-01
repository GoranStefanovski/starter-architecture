<!DOCTYPE html>
<html>
<head>
    <title>New Leave Request</title>
</head>
<body>
    <h2>New Leave Request Assigned to You</h2>
        <a href="{{ url('http://starter.test/admin/leave_request/' . $leaveRequest->id . '/confirmation') }}" target="_blank">
            Open Leave Request Confirmation Page
        </a>
    <p>Please review and take necessary actions.</p>
</body>
</html>