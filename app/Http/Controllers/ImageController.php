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

            $fileName = $this->uploadToCloudStorage($imageFile);
            $url = sprintf('https://storage.googleapis.com/%s/%s', env('CLOUD_STORAGE_BUCKET'), $fileName);

            return [
                'imageUrl' => $url,
                'classification' => $classificationResult['result'] ?? null,
                'statusCode' => $statusCode,
            ];
        } catch (Exception $e) {

            throw $e;
        }
    }


    /**
     * Upload the image to cloud storage and return the file name.
     */
    private function uploadToCloudStorage(Request $request)
    {
        try {

            $imageFile = $request->file('image');

            $filePath = env('GOOGLE_CLOUD_KEY_FILE');
            $storage = new StorageClient([
               'keyFilePath' => $filePath
            ]);

            $bucketName = env('GOOGLE_CLOUD_STORAGE_BUCKET');
            $bucket = $storage->bucket($bucketName);

            $fileNameWithExtension = $imageFile->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();

            // Create a local temporary file and upload it to Google Cloud Storage
            $bucket->upload(
                fopen($imageFile->getRealPath(), 'r'), // Open the image file for reading
                [
                    'name' => 'history/' . $fileName, // Set the destination file name in Google Cloud Storage
                    
                ]
            );
            return $fileName;
        } catch (\Exception $e) {
            Log::error('Cloud Storage upload failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);


            throw new \Exception(
                'Cloud Storage Failed. Details: ' . $e->getMessage()
            );
        }
    }
}
