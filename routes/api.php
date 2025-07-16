<?php

use App\Http\Controllers\EmailLogController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('todos', TodoController::class);
Route::get('/email-logs', [EmailLogController::class, 'index']);
