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
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = new Todo;
        $todo->title = $request->title;
        $todo->save();

        return response()->json($todo, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update(['title' => $request->title]);

        return response()->json($todo);
    }


    public function destroy($id)
    {
        $todo = Todo::find($id);

        if ($todo) {
            $todo->delete();
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'Todo not found'], 404);
    }
}
