<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function show($prediction)
    {
        $data = DB::table('tomato_leave_status')->select('id','status_name','healing_steps')->where('code','=',$prediction)->first();

        return [
            "disease" => $data
        ];
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
