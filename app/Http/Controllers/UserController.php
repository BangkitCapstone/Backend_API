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
    Public function changePassword(Request $request){
        try {

            $request->validate([
                "user_id" => "required",
                "old_password" => "required",
                "new_password" => "required"
            ]);

            $user = User::where('id', $request->get('user_id'))->first();

            if (!$user || !Hash::check($request->input('old_password'), $user->password)) {
                return response()->json([
                    'status' => 'fail',
                    'error_code' => 'INVALID_CREDENTIALS',
                    'message' => 'Update password fail! wrong password !',
                ], Response::HTTP_OK);
            }

            $user->password = bcrypt($request->get('new_password'));
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'User update password succesfully'
            ], Response::HTTP_OK);

        } catch (ValidationException  $e) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'VALIDATION_FAILED',
                'message' => 'Validation failed for change password data',
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

    public function updateUser(Request $request){
        try {
                $request->validate([
                    'user_id' => 'required|string',
                    'new_username' => 'string|nullable',
                    'new_email' => 'string|nullable',
                    'image' => 'image|mimes:jpg,jpeg,png|max:5048|nullable',
                ]);
                $userId = $request->get('user_id');
                $user = User::find($userId);

                if (!$user) {
                    return response()->json([
                        'status' => 'error',
                        'error_code' => 'USER_NOT_FOUND',
                        'message' => 'No user found with the provided user ID',
                    ], Response::HTTP_NOT_FOUND);
                }

                $fieldsToUpdate = [];

                if ($request->has('new_username') && !is_null($request->get('new_username'))) {
                    $fieldsToUpdate['username'] = $request->get('new_username');
                }

                if ($request->has('new_email') && !is_null($request->get('new_email'))) {
                    $fieldsToUpdate['email'] = $request->get('new_email');
                }

                if ($request->hasFile('image')) {
                    $imageController = new ImageController;
                    $imageFile = $request->file('image');
                    $url = $imageController->uploadToCloudStorage($imageFile, 'profile_picture');
                    $fieldsToUpdate['profile_picture'] = $url;
                }

                if (!empty($fieldsToUpdate)) {
                    $user->update($fieldsToUpdate);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'User data updated successfully',
                    'result' => $fieldsToUpdate,
                ], Response::HTTP_OK);
        } catch (ValidationException  $e) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'VALIDATION_FAILED',
                'message' => 'Validation failed for change password data',
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
