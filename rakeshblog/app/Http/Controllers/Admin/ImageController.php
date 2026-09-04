<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        try {
            Log::info('Image upload request received');

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $image = $request->file('image');
            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('blog-images', $filename, 'media');

            Log::info('Image uploaded successfully: ' . $path);

            return response()->json([
                'success' => true,
                'path' => Storage::disk('media')->url($path),
                'filename' => $filename,
                'message' => 'Image uploaded successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            Log::info('Image delete request received');

            $request->validate([
                'path' => 'required|string',
            ]);

            $path = $this->storagePath($request->path);
            if (Storage::disk('media')->exists($path)) {
                Storage::disk('media')->delete($path);
                Log::info('Image deleted successfully: ' . $path);
                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Image delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }

        private function storagePath(string $value): string
        {
            $path = parse_url($value, PHP_URL_PATH) ?: $value;

            return ltrim(preg_replace('/^\/?storage\//', '', $path), '/');
        }
    }
}