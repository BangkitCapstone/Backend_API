<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class UserController extends Controller
{
    Public function updateUser(Request $request){
        try {

            $request->validate([
                "user_id" => "required",
                "old_password" => "required",
                "new_password" => "required"
            ]);

            $user = User::where('id', $request->get('user_id'))->first();

            if (!$user || !Hash::check($request->input('old_password'), $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'error_code' => 'INVALID_CREDENTIALS',
                    'message' => 'The provided password is incorrect',
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user->password = bcrypt($request->get('new_password'));
            $user->save();
            

            return response()->json([
                'message' => 'User update password succesfully',
            ], Response::HTTP_OK);

            return response()->json([
                'message' => 'User has been successfully login',
            ], Response::HTTP_CREATED);
        } catch (ValidationException  $e) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'VALIDATION_FAILED',
                'message' => 'Validation failed for the login input data',
                'details' => $e->errors()
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'error',
                'error_code' => 'INTERNAL_SERVER_ERROR',
                'message' => 'An unexpected error occured in backend API',
                'details' => [
                    'exception' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
