<?php

namespace App\Http\Controllers;

use Exception;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage($imageFile)
    {
        try {
            $fastApiEndpoint = 'https://capstone-project-441614.et.r.appspot.com/predict-image';

            $response = Http::attach(
                'file',
                file_get_contents($imageFile->getRealPath()),
                $imageFile->getClientOriginalName()
            )->post($fastApiEndpoint);


            if ($response->failed()) {
                throw new \Exception(
                    'Failed to get classification result from FastAPI. ' .
                        'Fast API Status Code: ' . $response->status() . '. ' .
                        'Fast API Response Body: ' . $response->body()
                );
            }


            $classificationResult = $response->json();
            $statusCode = $classificationResult['prediction'];

            $url = $this->uploadToCloudStorage($imageFile,'history');


            return [
                'imageUrl' => $url,
                'statusCode' => $statusCode
            ];
        } catch (Exception $e) {

            throw $e;
        }
    }


    /**
     * Upload the image to cloud storage and return the file name.
     */
    public function uploadToCloudStorage($imageFile,$folder)
    {
        try {
            $storage = new StorageClient();

            $bucketName = env('GOOGLE_CLOUD_STORAGE_BUCKET');
            $bucket = $storage->bucket($bucketName);

            $fileNameWithExtension = $imageFile->getClientOriginalName();
            $fileName = uniqid() . '.' . $imageFile->getClientOriginalExtension();

            $bucket->upload(
                fopen($imageFile->getRealPath(), 'r'),
                [
                    'name' => $folder.'/' . $fileName,
                ]
            );

            $url = sprintf(
                'https://storage.googleapis.com/%s/%s/%s',
                $bucketName,
                $folder,
                $fileName
            );
            return $url;
        } catch (\Exception $e) {

            throw new \Exception(
                'Cloud Storage Failed. Details: ' . $e->getMessage()
            );
        }
    }
}
