<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('todos');
});

Route::get('/todos/create', function () {
    return view('create-todo');
});

Route::get('/todos/{id}/edit', function ($id) {
    return view('edit-todo', ['id' => $id]); // send ID to frontend
});
