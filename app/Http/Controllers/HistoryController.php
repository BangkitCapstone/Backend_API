<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        


         //PLACEHOLDER DOANG

         $diseaseName = "test";

         /*
         CATATAN AWAL
         - jadi hasil url gambrnya bakal dikirim ke endpoint ML
         - endpoint ML bakal ngirim nama penyakit
         - search cara penangannya pakai function query
         - Hasil query disimpan ke db(disease id,step healing, user id , filepath image)
         - Data hasil identifikasi penyakitnya dikirim ke android APP
 
 
         */



    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        //
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
