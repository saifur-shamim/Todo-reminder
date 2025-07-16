<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<div class="container">
    <a href="/" class="btn btn-dark mb-3">Back to Todos</a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3 class="text-primary mb-4">➕ Create New Todo</h3>
                <form id="todoForm">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="due_datetime" class="form-label">Due Date & Time *</label>
                        <input type="datetime-local" class="form-control" id="due_datetime" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Create Todo</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('todoForm').addEventListener('submit', async function (event) {
        event.preventDefault();

        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const due_datetime = document.getElementById('due_datetime').value;

        if (!title) {
            alert("Title is required.");
            return;
        }

        if (!due_datetime) {
            alert("Due date and time is required.");
            return;
        }

        const dueDate = new Date(due_datetime);
        if (dueDate <= new Date()) {
            alert("Due date and time must be in the future.");
            return;
        }

        const response = await fetch('/api/todos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ title, description, due_datetime }),
        });

        if (response.ok) {
            window.location.href = '/'; // redirect to home page
        } else {
            const error = await response.json();
            alert("Error: " + (error.message || "Unable to create todo"));
        }
    });
</script>
</body>
</html>
