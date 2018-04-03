<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('order')->get();

        return response()->json($task, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'order' => $request->order
        ]);

        $status = $task->save();

        $data = [
            'status' => $status,
            'message' => ($status) ? 'Task Created!' : 'Error Creating Task',
            'data' => $task
        ];
        
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {   
       return response()->json($task, 200); 
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
        if($request->isMethod('PUT'))
        {
            $status = $task->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'user_id' => $request->user_id,
                'order' => $request->order
            ]);
        }else
        {
            $status = $task->update([
                'name' => $request->name ?: $task->name,
                'category_id' => $request->category_id ?: $task->category_id,
                'user_id' => $request->user_id ?: $task->user_id,
                'order' => $request->order ?: $task->order
            ]);
        }

        $data = [
            'status' => $status,
            'message' => ($status) ? 'Task Updated!' : 'Error Updating Task'
        ];

        return response()->json($data, 200);
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

        $data = [
            'status' => $status,
            'message' => ($status) ? 'Task Deleted!' : 'Error Deleting Task'
        ];

        return response()->json($data, 200);
    }
}
