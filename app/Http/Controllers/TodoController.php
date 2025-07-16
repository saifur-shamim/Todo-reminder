<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return Todo::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_datetime' => 'required|date|after:now',
        ]);

        $todo = Todo::create($validated);
        return response()->json($todo, 201);
    }

    public function show(Todo $todo) // route model binding
    {
        return $todo;
    }

    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
            'due_datetime' => 'sometimes|date|after:now',
        ]);

        $todo->update($validated);
        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(['message' => 'Todo deleted']);
    }
}
