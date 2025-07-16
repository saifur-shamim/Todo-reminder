<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<div class="container">
    <a href="/" class="btn btn-secondary mb-3"> Back to Todos</a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3 class="text-primary mb-4">✏️ Edit Todo</h3>
                <form id="editForm">
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
                    <button type="submit" class="btn btn-primary w-100">Update Todo</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const todoId = "{{ $id }}";
    const API_URL = `/api/todos/${todoId}`;

    async function loadTodo() {
        const res = await fetch(API_URL);
        const todo = await res.json();

        document.getElementById('title').value = todo.title;
        document.getElementById('description').value = todo.description || '';
        document.getElementById('due_datetime').value = new Date(todo.due_datetime).toISOString().slice(0, 16);
    }

    document.getElementById('editForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const due_datetime = document.getElementById('due_datetime').value;

        // Frontend Validation
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
            alert("Due date must be in the future.");
            return;
        }

        const response = await fetch(API_URL, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ title, description, due_datetime }),
        });

        if (response.ok) {
            window.location.href = '/';
        } else {
            const error = await response.json();
            alert("Error: " + (error.message || "Failed to update todo"));
        }
    });

    loadTodo();
</script>
</body>
</html>
