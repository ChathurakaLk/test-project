<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaUploadRequest;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function uploadImages(MediaUploadRequest $request)
    {
        try {
            $files = $request->file('images');
            $uploadedPaths = [];

            foreach ($files as $file) {
                $path = $file->store('media');
                $uploadedPaths[] = $path;
            }

            return response()->json([
                'success' => true,
                'message' => 'Files uploaded successfully.',
                'file_paths' => $uploadedPaths,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'File upload failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function saveImages(array $validatedData, $modelType, $modelId, $modelCategory)
    {
        try {
            $uploadedMedia = [];
            $images = json_decode($validatedData['images'], true);

            // Check if images were decoded successfully
            if (!$images || !is_array($images)) {
                throw new Exception('Invalid images data format.');
            }

            if (count($images) > 5) {
                throw new Exception('You can upload a maximum of 5 images.');
            }

            // Loop through each image path and save to media
            foreach ($images as $imagePath) {
                $media = Media::create([
                    'name' => basename($imagePath[0]), // Extract the file name
                    'path' => $imagePath[0],          // Store the file path
                    'type' => 'image',                // Assuming these are all images
                    'model_type' => $modelType,
                    'model_id' => $modelId,
                    'model_category' => $modelCategory,
                ]);

                $uploadedMedia[] = $media;
            }

            return $uploadedMedia;
        } catch (Exception $e) {
            info($e->getMessage());
            throw $e;
        }
    }
}
