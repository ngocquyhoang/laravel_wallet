<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * User profile validator.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     */
    protected function validator($request, $user)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validation = $this->validator($request->all(), $user);

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
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
