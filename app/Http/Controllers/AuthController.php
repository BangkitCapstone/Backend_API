<?php

namespace App\Http\Controllers;


use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'email' => 'required',
            ]);

            $user = new User();
            $user->username = $request->get('username');
            $user->password = bcrypt($request->get('password'));
            $user->email = $request->get('email');
            $user->save();

            return response()->json([
                'message' => 'User has been successfully created',
            ], Response::HTTP_CREATED);
        } catch (ValidationException  $e) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'VALIDATION FAILED',
                'message' => 'Validation failed for the register input data',
                'details' => $e->errors()
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'error',
                'error_code' => 'INTERNAL SERVER ERROR',
                'message' => 'An unexpected error occured in backend API',
                'details' => [
                    'exception' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        try {

            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'error_code' => 'INVALID_CREDENTIALS',
                    'message' => 'The provided email or password is incorrect',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'message' => 'User logged in successfully',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'profile_picture' => $user->profile_picture
                ]
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
