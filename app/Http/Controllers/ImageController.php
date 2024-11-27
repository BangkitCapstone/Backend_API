<?php

namespace App\Http\Controllers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function uploadImage($imageFile){
        
        // $request->validate([
        //     'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        //     'userId' => 'required|string',
        // ]);


        $file = $imageFile;
       

        $bucketName = env('CLOUD_STORAGE_BUCKET');
        $storage = new StorageClient();
        $bucket = $storage->bucket($bucketName);

        $fileName = 'history/'.uniqid().'.'.$file->getClientOriginalExtension();

        $bucket->upload(
            fopen($file->getPathname(),'r'),
            ['name'=>$fileName]
        );

        $url = sprintf('https://storage.googleapis.com/%s/%s', $bucketName, $fileName);

        
        /*
            PLACEHOLDER ENDPOINT APInya

        */


       $diseaseName = "test";

       return [
        "imageUrl" => $url,
        "diseaseName" => $diseaseName
       ];

    }
}
