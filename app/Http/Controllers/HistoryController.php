<?php

namespace App\Http\Controllers;

use App\Models\History;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = History::all();

        return response()->json(["datas" => $datas]);
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

            $imageController = new ImageController;
            $diseaseController = new DiseaseController;

            $request->validate([
                'userId' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5048',
                'currDate' => 'required'
            ]);

            $userId = $request->get('id');
            $imageFile = $request->file('image');
            $currDate = $request->get('currDate');

            $imageData = $imageController->uploadImage($imageFile);
            $urlImage = $imageData['imageUrl'];
            $prediction  = $imageData['statusCode'];
            $predictionData = $diseaseController->show($prediction);
            $predId = $predictionData['id'];

            $history  = new History;
            $history->image_path = $urlImage;
            $history->users_id = $userId;
            $history->disease_id = $predId;
            $history->date =  $currDate;
            $history->save();

            return response()->json([
                'message' => 'Image has been uploaded'
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
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

    public function show(History $history) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        //
    }

    public function userHistories(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $userId = $request->user_id;

        // Query all histories based on user_id, join tomato_leave_status to get status_name
        $histories = History::join('tomato_leave_status', 'upload_histories.status_id', '=', 'tomato_leave_status.id')
            ->where('upload_histories.users_id', $userId)
            ->select(
                'upload_histories.id',
                'upload_histories.image_path',
                'upload_histories.date',
                'tomato_leave_status.status_name'
            )
            ->get();

        return response()->json([
            'data' => $histories,
        ], Response::HTTP_OK);
    }

    public function userUploadHistory(Request $request) {
        $request->validate([
            'user_id' => 'required|integer',
            'history_id' => 'required|integer',
        ]);

        $userId = $request->user_id;
        $historyId = $request->history_id;

        // Query individual history, join tomato_leave_status to get status_name and healing_steps
        $history = History::join('tomato_leave_status', 'upload_histories.status_id', '=', 'tomato_leave_status.id')
            ->where('upload_histories.users_id', $userId)
            ->where('upload_histories.id', $historyId)
            ->select(
                'upload_histories.id',
                'upload_histories.image_path',
                'upload_histories.date',
                'tomato_leave_status.status_name',
                'tomato_leave_status.healing_steps'
            )
            ->first();

        if (!$history) {
            return response()->json([
                'error' => 'History not found for this user.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $history,
        ], Response::HTTP_OK);
    }
}
