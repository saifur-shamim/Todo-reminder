<!DOCTYPE html>
<html>

<head>
    <title>Todo Reminder</title>
</head>

<body>
    <h2>🔔 Reminder: {{ $todo->title }}</h2>
    <p>{{ $todo->description }}</p>
    <p><strong>Due at:</strong> {{ $todo->due_datetime }}</p>
</body>

</html>