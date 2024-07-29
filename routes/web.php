<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todos/{id}/edit', function ($id) {
    return view('editTodo', ['id' => $id]);
});

Route::get('/api/todos', [TodoController::class, 'index']);
Route::post('/api/todos', [TodoController::class, 'store']);
Route::delete('/api/todos/{id}', [TodoController::class, 'destroy']);
Route::put('/api/todos/{id}', [TodoController::class, 'update']);
