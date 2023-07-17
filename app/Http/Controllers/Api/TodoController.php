<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        if ($todos->count() > 0) {
            return response()->json([
                'status' => 200,
                'todos'  => $todos
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message'  => "There is no records found!"
            ], 200);
        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);

        } else{
            Todo::create([
                'title'         => $request->title,
                'description'   => $request->description,
            ]);

            return response()->json([
                'status'    => 200,
                'message'   => "Todo was created successfully!"
            ],200);
        }


    }

    public function edit(Todo $todo)
    {
        return response()->json([
            'status' => 200,
            'todo'   => $todo
        ], 200);
    }

    public function update(Request $request, Todo $todo)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);

        } else{
            $todo->update([
                'title'         => $request->title,
                'description'   => $request->description,
            ]);

            return response()->json([
                'status'    => 200,
                'message'   => "Todo was updated successfully!"
            ],200);
        }
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json([
            'status' => 200,
            'message' => "Todo was deleted successfully"
        ],200);
    }
}
