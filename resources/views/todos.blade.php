<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }

        .todo-item-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .todo-item-date {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .badge-success {
            font-size: 0.75rem;
        }
    </style>
</head>
<body class="p-4">
<div class="container">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">📝 Todo List Manager</h1>
        <p class="text-muted">Keep track of your tasks with ease and style!</p>
        <a href="/todos/create" class="btn btn-success mt-2">➕ Create Todo</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="mb-3 text-secondary">🗂 All Todos</h3>
            <ul id="todoList" class="list-group shadow-sm">
                <!-- Todo items will go here -->
            </ul>
        </div>
    </div>
</div>

<script>
    const API_URL = '/api/todos';

    async function fetchTodos() {
        const response = await fetch(API_URL);
        const todos = await response.json();

        const list = document.getElementById('todoList');
        list.innerHTML = '';

        todos.forEach(todo => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-start flex-wrap';

            const content = document.createElement('div');
            content.className = 'flex-grow-1';
            content.innerHTML = `
                <div class="todo-item-title">${todo.title}</div>
                <div class="todo-item-date">${new Date(todo.due_datetime).toLocaleString()}</div>
                ${todo.description ? `<div class="text-muted small mt-1">${todo.description}</div>` : ''}
                ${todo.email_sent ? '<span class="badge bg-success mt-2">Email Sent</span>' : ''}
            `;

            const actions = document.createElement('div');
            actions.className = 'd-flex align-items-center gap-2 mt-2 mt-sm-0';
            actions.innerHTML = `
                <a href="/todos/${todo.id}/edit" class="btn btn-sm btn-outline-warning">Edit</a>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteTodo(${todo.id})">Delete</button>
            `;

            li.appendChild(content);
            li.appendChild(actions);
            list.appendChild(li);
        });
    }

    async function deleteTodo(id) {
        if (!confirm("Are you sure you want to delete this todo?")) return;

        await fetch(`${API_URL}/${id}`, {
            method: 'DELETE',
        });

        fetchTodos();
    }

    fetchTodos();
</script>
</body>
</html>
