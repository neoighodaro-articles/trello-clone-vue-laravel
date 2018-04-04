<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Task::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $task = Task::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'order' => $request->order
        ]);
        
        return response()->json([
            'status' => (bool) $task,
            'data'   => $task,
            'message' => $task ? 'Task Created!' : 'Error Creating Task'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {   
       return response()->json($task); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        
        $status = $task->update(
            $request->only(['name', 'category_id', 'user_id', 'order'])
        );
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Task Updated!' : 'Error Updating Task'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        
        $status = $task->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Task Deleted!' : 'Error Deleting Task'
        ]);
    }
}
