<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index() {
        return Todo::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'title' => $validated['title'],
            'done' => false,
        ]);

        return response()->json($todo, 201);
    }

    public function makeDone(Todo $todo)
    {
        $todo->update(['done' => true]);

        return response()->json($todo);
    }
}
