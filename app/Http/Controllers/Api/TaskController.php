<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/tasks
     */
    public function index()
    {

        try {
            $tasks = Task::with('responsible')->get();
            return response()->json([
                'status' => true,
                'message' => "Tasks",
                'response' => $tasks
            ], 200);
        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on tasks display!",
                'response' => $e
            ], 500);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/tasks
     */
    public function store(Request $request)
    {
        
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:50'],
                'priority' => ['required', 'string', 'max:50'],
                'status' => ['required', 'string', 'max:50'],
                'description' => ['required', 'string', 'max:200'],
                'scheduled_at' => ['required'],
                'user_id' => ['required'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'status' => false,
                    'message' => "Bad request",
                    'response' => $errors
                ], 400);
            }

            $task = Task::create($data);
            return response()->json([
                'status' => true,
                'message' => "Task",
                'response' => $task
            ], 200);

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on task creation",
                'response' => $e
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     * GET /api/tasks/{task_id}
     */
    public function show(Request $request, $task_id)
    {

        try {
            $task = Task::find($task_id);
            if( $task ) {
                return response()->json([
                    'status' => true,
                    'message' => "Task",
                    'response' => $task
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "Task not found!",
                    'response' => $task
                ], 404);
            }            

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on task loading",
                'response' => $e
            ], 500);
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/tasks/{task_id}
     */
    public function update(Request $request, $task_id)
    {

        try {

            $task = Task::find($task_id);

            if( $task ) {
                $data = $request->all();
    
                $validate_values = [];
    
                if( isset($data['name']) )
                    $validate_values['name'] = ['required', 'string', 'max:50'];
    
                if( isset($data['priority']) )
                    $validate_values['priority'] = ['required', 'string', 'max:50'];
    
                if( isset($data['status']) )
                    $validate_values['status'] = ['required', 'string', 'max:50'];
    
                if( isset($data['description']) )
                    $validate_values['description'] = ['required', 'string', 'max:200'];
    
                if( isset($data['scheduled_at']) )
                    $validate_values['scheduled_at'] = ['required'];
    
                if( isset($data['user_id']) )
                    $validate_values['user_id'] = ['required'];
    
                $validator = Validator::make($data, $validate_values);
    
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    return response()->json([
                        'status' => false,
                        'message' => "Bad request",
                        'response' => $errors
                    ], 400);
                }

                if( isset($data['created_at']) )
                unset($data['created_at']);

                if( isset($data['updated_at']) )
                    unset($data['updated_at']);
    
                $task->update($data);
                return response()->json([
                    'status' => true,
                    'message' => "Task",
                    'response' => $task
                ], 200);

            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => "Task not found!",
                    'task' => $task
                ], 404);
            }

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on tasks display!",
                'response' => $e
            ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/tasks/{task_id}
     */
    public function destroy(Request $request, $task_id)
    {
        try {
            $task = Task::find($task_id);
            if( $task ) {
                $task->delete();
                return response()->json([
                    'status' => true,
                    'message' => "Task Deleted successfully!",
                    'response' => $task
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "Task not found!",
                    'response' => $task_id
                ], 404);
            }
        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on tasks display!",
                'response' => $e
            ], 500);
        }


    }
}
