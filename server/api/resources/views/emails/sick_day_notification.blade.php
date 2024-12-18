<!DOCTYPE html>
<html>
<body>
    <h3>Sick Day Taken</h3>
    <p>An employee has taken a sick day.</p>
    <p>Details:</p>
    <ul>
        <li>Day Type: {{ $vacationDay->day_type_id }}</li>
        <li>Date: {{ $vacationDay->created_at }}</li>
    </ul>
</body>
</html>
