<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function uploadImage(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        return response()->json([
            'message' => 'Upload foto berhasil'

        ],Response::HTTP_CREATED);
    }
}
