<?php

namespace App\Http\Controllers;

use App\Models\History;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = History::all();
        
        return response()->json(["datas"=>$datas]);
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
        try{
            $request->validate([
                'userId'=>'required|string',
                'image' =>'required|image|mimes:jpg,jpeg,png|max:2048',
                'currDate' => 'required'
            ]);
    
            $userId = $request->get('id');
            $imageFile = $request->file('image');
            $currDate = $request->get('currDate');
    
            $imageController = new ImageController;
            $diseaseController = new DiseaseController;
    
            $imageData = $imageController->uploadImage($imageFile);
    
            $urlImage = $imageData['imageUrl'];
            $diseaseName = $imageData['diseaseName'];
    
            $diseaseData = $diseaseController->show($diseaseName);
    
            $dsId = $diseaseData['id'];
            
    
            $history  = new History;
            $history->image_path = $urlImage;
            $history->users_id = $userId;
            $history->disease_id = $dsId;
            $history->date =  $currDate;
            $history->save();

            return response()->json([
                'message' => 'Image has been uploaded' 
            ],201);


        } catch (ValidationException $e){
            return response()->json([
                'error' => 'Data Validation Failed',
                'details' => $e->errors()
            ], 422);
        } catch (Exception $e){
            return response()->json([
                'error' => 'An error occured in backend API',
                'details' => $e->getMessage()
            ], 500);
        }
        
            
    
       
        
        
         /*
         CATATAN AWAL
         - jadi hasil url gambarnya bakal dikirim ke endpoint ML
         - endpoint ML bakal ngirim nama penyakit
         - search cara penangannya pakai function query
         - Hasil query disimpan ke db(disease id,step healing, user id , filepath image)
         - Data hasil identifikasi penyakitnya dikirim ke android APP   */
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $datas = History::find($id);

            return response()->json(["userHistory"=>$datas],200);
        }catch(Exception $e){
            return response()->json([
                'error' => 'An error occured in backend API',
                'details' => $e->getMessage()
            ], 500);
        }
       
    }

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
}
