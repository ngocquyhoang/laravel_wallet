<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Hash;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * User profile validator.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     */
    protected function profile_validator($request, $user)
    {
        return Validator::make(
            $request,
            [
                'username' => 'required|alpha_num|min:4|max:32|unique:users,username,'.$user->id,
                'full_name' => 'sometimes|nullable|string|min:8|max:255',
                'phone_number' => 'sometimes|nullable|phone:VN,US',
                'dob' => 'sometimes|nullable|date',
            ]
        );
    }

    /**
     * User password params validator.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     */
    protected function password_validator($request, $user)
    {
        return Validator::make(
            $request,
            [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validation = $this->profile_validator($request->all(), $user);

        if ($validation->fails()) 
        {
            return response()->json([
                'status' => false,
                'message' => json_decode($validation->errors())
            ], 403);
        }

        try {
            $user->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Your profile has been successfully updated.'
            ], 201);
        } catch (Exception $exception) {
            // $exception->getMessage(); -> for logging
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong please try again.'
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, User $user)
    {
        $validation = $this->password_validator($request->all(), $user);
        if ($validation->fails()) 
        {
            return response()->json([
                'status' => false,
                'message' => json_decode($validation->errors())
            ], 403);
        }

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) 
        {
            return response()->json([
                'status' => false,
                'message' => [
                    'current_password' => [
                        'Your current password is invalid'
                    ]
                ]
            ], 403);
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0)
        {
            return response()->json([
                'status' => false,
                'message' => [
                    'new_password' => [
                        'New Password cannot be same as your current password'
                    ]
                ]
            ], 403);
        }

        $user->password = bcrypt($request->get('new_password'));

        try {
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Your password has been successfully changed.'
            ], 201);
        } catch (Exception $exception) {
            // $exception->getMessage(); -> for logging
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong please try again.'
            ], 400);
        }
    }
}
