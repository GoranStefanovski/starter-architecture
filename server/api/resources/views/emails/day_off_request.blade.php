<!DOCTYPE html>
<html>
<body>
    <h3>Day Off Request</h3>
    <p>Employee has requested a day off.</p>
    <p>Details:</p>
    <ul>
        <li>Day Type: {{ $vacationDay->day_type_id }}</li>
        <li>Request Handler ID: {{ $vacationDay->request_handler_id }}</li>
    </ul>
</body>
</html>
