<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Disease::all();

        return response()->json(["data"=>$datas]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Disease::find($id);

        return response()->json(["data"=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disease $diseases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disease $diseases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disease $diseases)
    {
        //
    }
}
