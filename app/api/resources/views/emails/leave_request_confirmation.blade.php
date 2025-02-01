<!DOCTYPE html>
<html>
<head>
    <title>APPROVED</title>
</head>
<body>
    <h2>Your Leave Request Has Been Approved</h2>
        <a href="{{ url('http://starter.test/admin/leave_request/' . $leaveRequest->id) }}" target="_blank">
            Open Leave Request
        </a>
</body>
</html>