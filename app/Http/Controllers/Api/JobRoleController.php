<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jobRoles = JobRole::all();
            return response()->json([
                'status' => true,
                'message' => "JobRoles",
                'response' => $jobRoles
            ], 200);
        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on users display!",
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

    private function fill_created_at($user_data)
    {
        $user_data['created_at'] = now();
        return $user_data;
    }

    private function fill_updated_at($user_data)
    {
        $user_data['updated_at'] = now();
        return $user_data;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:50'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'status' => false,
                    'message' => "Bad request",
                    'response' => $errors
                ], 400);
            }

            $data = $this->fill_created_at($data);
            $data = $this->fill_updated_at($data);

            $jobRole = JobRole::create($data);
            return response()->json([
                'status' => true,
                'message' => "JobRole",
                'response' => $jobRole
            ], 200);

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on JobRole creation",
                'response' => $e
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $job_role_id)
    {
        try {
            $jobRole = JobRole::find($job_role_id);
            if( $jobRole ) {
                return response()->json([
                    'status' => true,
                    'message' => "JobRole",
                    'response' => $jobRole
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "JobRole not found!",
                    'response' => $jobRole
                ], 404);
            }            

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on JobRole loading",
                'response' => $e
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobRole $jobRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $job_role_id)
    {
        try {
            $jobRole = JobRole::find($job_role_id);

            if( $jobRole ) {
                $data = $request->all();

                $validate_values = [];

                if( isset($data['name']) )
                    $validate_values['name'] = ['required', 'string', 'max:50'];

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

                $data = $this->fill_updated_at($data);
                $jobRole->update($data);
                return response()->json([
                    'status' => true,
                    'message' => "JobRole",
                    'response' => $jobRole
                ], 200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => "JobRole not found!",
                    'response' => $jobRole
                ], 404);
            }
        } catch (Throwable $e) {
        
            return response()->json([
                'status' => false,
                'message' => "Error on response display!",
                'response' => $e
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $job_role_id)
    {
        try {
            $jobRole = JobRole::find($job_role_id);
            if( $jobRole ) {
                $jobRole->delete();
                return response()->json([
                    'status' => true,
                    'message' => "JobRole Deleted successfully!",
                    'response' => $jobRole
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "JobRole not found!",
                    'response' => $job_role_id
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
