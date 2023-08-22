<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserJobRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserJobRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $userJobRole = UserJobRole::all();
            return response()->json([
                'status' => true,
                'message' => "UserJobRole",
                'response' => $userJobRole
            ], 200);
        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on userJobRole display!",
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
     */
    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'user_id' => ['required'],
                'job_role_id' => ['required']
            ]);

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

            $userJobRole = UserJobRole::create($data);

            return response()->json([
                'status' => true,
                'message' => "UserJobRole",
                'response' => $userJobRole
            ], 200);

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on userJobRole creation",
                'response' => $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $user_id)
    {
        
        try {
            $userJobRole = UserJobRole::firstOrFail()->where('user_id', $user_id);
            if( $userJobRole ) {
                return response()->json([
                    'status' => true,
                    'message' => "UserJobRole",
                    'response' => $userJobRole
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "UserJobRole not found!",
                    'response' => $userJobRole
                ], 404);
            }

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on userJobRole loading",
                'response' => $e
            ], 500);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserJobRole $userJobRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserJobRole $userJobRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserJobRole $userJobRole)
    {
        //
    }
}
