<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UpscaleController extends Controller
{
    public function upscale(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png|max:5120', // Max 5MB
        ]);

        try {
            $image = $request->file('image');

            // Create directories if they don't exist
            $uploadPath = public_path('uploads');
            $outputPath = public_path('output_generated');

            if (!File::exists($uploadPath)) File::makeDirectory($uploadPath, 0755, true);
            if (!File::exists($outputPath)) File::makeDirectory($outputPath, 0755, true);

            // Generate unique filename
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $uploadedFilePath = $uploadPath . '/' . $filename;
            $outputFilePath = $outputPath . '/upscaled_' . $filename;

            // Move uploaded file
            $image->move($uploadPath, $filename);

            // Load image via Imagick
            $imagick = new \Imagick($uploadedFilePath);

            // Get original size
            $originalWidth = $imagick->getImageWidth();
            $originalHeight = $imagick->getImageHeight();

            // Resize to 2X
            $newWidth = $originalWidth * 2;
            $newHeight = $originalHeight * 2;

            $imagick->resizeImage($newWidth, $newHeight, \Imagick::FILTER_LANCZOS, 1);

            // Save upscaled image
            $imagick->writeImage($outputFilePath);
            $imagick->clear();
            $imagick->destroy();

            // Public URLs for Blade view
            $outputUrl = asset('output_generated/upscaled_' . $filename);

            return redirect()->route('success')->with([
                'success' => '✅ Image has been successfully upscaled 2X!',
                'output_image' => $outputUrl,
                'original_width' => $originalWidth,
                'original_height' => $originalHeight,
                'new_width' => $newWidth,
                'new_height' => $newHeight,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Failed to process image: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('success');
    }
}
