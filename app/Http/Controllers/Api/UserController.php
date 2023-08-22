<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private function secure($user_data)
    {
        //Add remember_token
        $user_data['remember_token'] = Str::random(60);
        // Password encryption
        if( isset($user_data['password']) )
            $user_data['password'] = bcrypt($user_data['password']);

        return $user_data;
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

    private function fill_email_verified_at($user_data)
    {
        $user_data['email_verified_at'] = now();
        return $user_data;
    }

    /**
     * Display a listing of the resource.
     * GET /api/users
     */
    public function index()
    {
        try {
            //$users = User::all();
            $users = User::with('job_roles')->get();
            return response()->json([
                'status' => true,
                'message' => "Users",
                'response' => $users
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
        /*
        $create_values = [];
        $create_values['name'] = 'required-string-max:50';
        $create_values['email'] = 'required-string-email-max:255';
        $create_values['name'] = 'required-string-min:8';
        return $create_values;
        */
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/users
     */
    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'status' => false,
                    'message' => "Bad request",
                    'response' => $errors
                ], 400);
            }

            $data = $this->secure($data);
            $data = $this->fill_email_verified_at($data);
            $data = $this->fill_created_at($data);
            $data = $this->fill_updated_at($data);

            $user = User::create($data);
            return response()->json([
                'status' => true,
                'message' => "User",
                'response' => $user
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
     * GET /api/users/{user_id}
     */
    public function show(Request $request, $user_id)
    {

        try {
            $user = User::find($user_id);
            if( $user ) {
                return response()->json([
                    'status' => true,
                    'message' => "User",
                    'response' => $user
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "User not found!",
                    'response' => $user
                ], 404);
            }            

        } catch (Throwable $e) {
     
            return response()->json([
                'status' => false,
                'message' => "Error on user loading",
                'response' => $e
            ], 500);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/users/{user_id}
     */
    public function update(Request $request, $user_id)
    {
        try {
            $user = User::find($user_id);

            if( $user ) {
                $data = $request->all();

                $validate_values = [];

                if( isset($data['name']) )
                    $validate_values['name'] = ['required', 'string', 'max:50'];

                if( isset($data['email']) )
                    $validate_values['email'] = ['required', 'string', 'email', 'max:255'];

                if( isset($data['password']) )
                    $validate_values['password'] = ['required', 'string', 'min:8'];

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

                $data = $this->secure($data);
                $data = $this->fill_updated_at($data);
                $user->update($data);
                return response()->json([
                    'status' => true,
                    'message' => "User",
                    'response' => $user
                ], 200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => "User not found!",
                    'response' => $user
                ], 404);
            }
        } catch (Throwable $e) {
        
            return response()->json([
                'status' => false,
                'message' => "Error on user display!",
                'response' => $e
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/users/{user_id}
     */
    public function destroy(Request $request, $user_id)
    {
        try {
            $user = User::find($user_id);
            if( $user ) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => "User Deleted successfully!",
                    'response' => $user
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "User not found!",
                    'response' => $user_id
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
